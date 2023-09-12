<?php

namespace App\Services\Cers;

use App\DataTransferObjects\Cers\CerData;
use App\Enums\Workflows\LastAction;
use App\Enums\Workflows\Status;
use App\Facades\Elasticsearch;
use App\Helpers\AuthHelper;
use App\Models\Cers\Cer;
use App\Repositories\Cers\CerRepository;
use App\Services\API\HRIS\EmployeeService;
use App\Services\API\TXIS\CerService as TXISCerService;
use App\Services\UserService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class CerService
{
    public function __construct(
        protected CerRepository $cerRepository,
        protected EmployeeService $employeeService,
    ) {
    }

    public function all($search = null)
    {
        $data = Elasticsearch::setModel(Cer::class)->searchMultiMatch($search, 50)->all();
        return CerData::collection(Arr::pluck($data, '_source'))->toCollection()->where('nik', AuthHelper::getNik());
    }

    public function updateOrCreate(CerData $data)
    {
        return DB::transaction(function () use ($data) {
            $cer = $this->cerRepository->updateOrCreate($data);
            if ($data->getKey()) {
                $cer->items()->delete();
                $cer->workflows()->delete();
            }
            $cer->items()->createMany($data->itemsToAttach());
            // cek site
            CerWorkflowService::setModel($cer)
                ->setBarrier($data->grandTotal())
                ->store();
            $this->sendToElasticsearch($cer, $data->getKey());
            return $cer;
        });
    }

    public function delete(Cer $cer)
    {
        return DB::transaction(function () use ($cer) {
            $cer->items()->delete();
            $cer->workflows()->delete();
            Elasticsearch::setModel(Cer::class)->deleted(CerData::from($cer));
            return $cer->delete();
        });
    }

    public function getListNoCerByUser(Request $request)
    {
        return Cer::query()->where('status', Status::CLOSE)->when($request->nik, function ($query, $nik) {
            $query->where('nik', $nik);
        })->when($request->email, function ($query, $email) {
            $query->whereHas('user', function ($query) use ($email) {
                $query->where('email', $email);
            });
        })->pluck('no_cer');
    }

    public function findByNo($no)
    {
        $cer = Cer::query()->with('items.uom')->where('no_cer', $no)->firstOrFail();
        return CerData::from($cer);
    }

    public static function getEmployee($nik = null): array
    {
        $token = UserService::getAdministrator()?->oatuhToken?->access_token;
        $nik = $nik ?? AuthHelper::getNik();
        $employee = (new EmployeeService)->setToken(auth()->check() ? null : $token)->getByNik($nik);
        return isset($employee['data']) ? $employee['data'] : [];
    }

    public static function getByCurrentApproval()
    {
        return Cer::query()->whereHas('workflows', function (Builder $query) {
            $query->where('last_action', LastAction::NOTTING)
                ->where('nik', AuthHelper::getNik());
        })->get();
    }

    public function getCerTxis($code)
    {
        $data = (new TXISCerService)->getByCode($code);
        return isset($data['data']) ? $data['data'] : [];
    }

    private function sendToElasticsearch(Cer $cer, $key)
    {
        $cer->load(['items', 'workflows']);
        if ($key) {
            return Elasticsearch::setModel(Cer::class)->updated(CerData::from($cer));
        }
        return Elasticsearch::setModel(Cer::class)->created(CerData::from($cer));
    }
}
