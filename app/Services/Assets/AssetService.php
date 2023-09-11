<?php

namespace App\Services\Assets;

use App\DataTransferObjects\Assets\AssetData;
use App\DataTransferObjects\Assets\AssetInsuranceData;
use App\DataTransferObjects\Assets\AssetLeasingData;
use App\Enums\Asset\Status;
use App\Facades\Elasticsearch;
use App\Http\Requests\Assets\AssetRequest;
use App\Jobs\Assets\BulkJob;
use App\Jobs\Assets\ImportJob;
use App\Models\Assets\Asset;
use App\Repositories\Assets\AssetInsuranceRepository;
use App\Repositories\Assets\AssetLeasingRepository;
use App\Repositories\Assets\AssetRepository;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Endroid\QrCode\Label\Font\OpenSans;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Label\Margin\Margin;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;

class AssetService
{
    public function __construct(
        protected AssetRepository $assetRepository,
        protected AssetInsuranceRepository $assetInsuranceRepository,
        protected AssetLeasingRepository $assetLeasingRepository,
    ) {
    }

    public function allNotElastic()
    {
        return Asset::query()->with(['unit', 'leasing', 'insurance'])->get();
    }

    public function all($search = null)
    {
        return Elasticsearch::setModel(Asset::class)->searchMultiMatch($search, 50)->all();
    }

    public function getById($id)
    {
        return Asset::query()->with([
            'unit',
            'subCluster',
            'insurance',
            'leasing',
            'uom',
        ])->find($id);
    }

    public function getByKode($kode)
    {
        return Asset::query()
            ->with(['unit', 'subCluster', 'insurance', 'leasing', 'uom'])
            ->where('kode', $kode)
            ->firstOrFail();
    }

    public function getByStatus(Status $status)
    {
        return Asset::query()->where('status', $status)->get();
    }

    public function getDataForEdit($id): array
    {
        $asset = Elasticsearch::setModel(Asset::class)->find($id)->asArray();
        return $asset['_source'];
    }

    public function updateOrCreate(AssetRequest $request)
    {
        $qrCode = AssetService::generateQRCode($request->kode, 250, filename: time() . $request->kode . '.png');
        $data = AssetData::from(array_merge($request->all(), ['qr_code' => $qrCode]));
        DB::transaction(function () use ($data, $request) {
            $asset = $this->assetRepository->updateOrCreate($data);
            $this->assetInsuranceRepository->updateOrCreateByAsset(AssetInsuranceData::fromRequest($request), $asset);
            $this->assetLeasingRepository->updateOrCreateByAsset(AssetLeasingData::fromRequest($request), $asset);
            $this->sendToElasticsearch($asset, $data->getKey());
        });
    }

    public function delete(Asset $asset)
    {
        return DB::transaction(function () use ($asset) {
            $this->assetInsuranceRepository->delete($asset->insurance);
            $this->assetLeasingRepository->delete($asset->leasing);
            Elasticsearch::setModel(Asset::class)->deleted(AssetData::from($asset));
            Storage::disk('public')->delete($asset->qr_code);
            return $asset->delete();
        });
    }

    public function import(array $data)
    {
        Asset::truncate();
        Elasticsearch::setModel(Asset::class)->cleared();
        $batch = Bus::batch([])->dispatch();
        foreach (array_chunk($data, 10) as $assets) {
            $batch->add(new ImportJob($assets));
        }
        return $batch;
    }

    public function startBulk()
    {
        $batch = Bus::batch([])->dispatch();
        $assets = $this->getDataBulk()?->toArray();
        foreach (array_chunk($assets, 10) as $assets) {
            $batch->add(new BulkJob($assets));
        }
        return $batch;
    }

    public static function bulk(array $assets = [])
    {
        $assets = count($assets) > 0 ? $assets : self::getDataBulk();
        Elasticsearch::setModel(Asset::class)->bulk(AssetData::collection($assets));
    }

    private static function getDataBulk()
    {
        return Asset::query()->with(['unit', 'subCluster', 'depreciations', 'depreciation', 'insurance', 'leasing', 'uom'])->get();
    }

    private function sendToElasticsearch(Asset $asset, $key)
    {
        $asset->load(['unit', 'subCluster', 'depreciations', 'depreciation', 'insurance', 'leasing', 'uom']);
        if ($key) {
            return Elasticsearch::setModel(Asset::class)->updated(AssetData::from($asset));
        }
        return Elasticsearch::setModel(Asset::class)->created(AssetData::from($asset));
    }


    public static function generateQRCode($content, $size = 100, $folder = 'qrcode', $filename = 'example.png', $label = 'PT. TATA BARA UTAMA')
    {
        $writer = new PngWriter();

        $qrCode = QrCode::create($content)
            ->setEncoding(new Encoding('UTF-8'))
            ->setErrorCorrectionLevel(new ErrorCorrectionLevelLow())
            ->setSize($size)
            ->setMargin(10)
            ->setRoundBlockSizeMode(new RoundBlockSizeModeMargin())
            ->setForegroundColor(new Color(0, 0, 0))
            ->setBackgroundColor(new Color(255, 255, 255));

        // $logo = Logo::create(public_path('assets/media/logos/tbu.png'))
        //     ->setResizeToWidth(round($size * 0.8))
        //     ->setPunchoutBackground(false);

        $label = Label::create($label)
            ->setFont(new OpenSans(round($size * 0.045)))
            ->setMargin(new Margin(-5, 10, 10, 10))
            ->setTextColor(new Color(34, 57, 104));

        $result = $writer->write($qrCode, label: $label);

        return self::saveBase64Image($result->getDataUri(), $folder, $filename);
    }

    public static function saveBase64Image($base64Data, $folder = 'qrcode', $filename = 'example.png')
    {
        $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64Data));;
        $path = $folder . '/' . $filename;
        Storage::disk('public')->put($path, $imageData);
        return $path;
    }
}
