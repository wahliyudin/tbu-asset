<?php

namespace App\Imports\Assets;

use App\Enums\Asset\Status;
use App\Facades\Assets\AssetService;
use App\Models\Masters\SubCluster;
use App\Models\Masters\Unit;
use App\Models\Masters\Uom;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class AssetImport implements ToArray, WithHeadingRow
{
    /**
     * @param array $data
     */
    public function array(array $data)
    {
        foreach ($data as $i => $val) {
            if ($val['unit'] == null) {
                unset($data[$i]);
            }
        }
        $results = [];
        foreach ($this->validate($data) as $val) {
            $val['kode'] = Str::random();
            $val['unit_id'] = Unit::query()->where('model', $val['unit'])->first()?->getKey();
            $val['sub_cluster_id'] = SubCluster::query()->where('name', $val['sub_cluster'])->first()?->getKey();
            $val['uom'] = Uom::query()->where('name', $val['uom'])->first()?->getKey();
            $val['status'] = Status::from($val['status']);
            $val['tgl_bast'] = Carbon::instance(Date::excelToDateTimeObject($val['tgl_bast']))->format('Y-m-d');
            unset($val['unit']);
            unset($val['sub_cluster']);
            array_push($results, $val);
        }
        AssetService::import($results);
    }

    private function validate($data)
    {
        $rules = [
            '*.unit' => ['required', 'exists:units,model'],
            '*.sub_cluster' => ['required', 'exists:sub_clusters,name'],
            '*.member_name' => 'required',
            '*.pic' => 'required',
            '*.activity' => 'required',
            '*.asset_location' => 'required',
            '*.kondisi' => 'required',
            '*.uom' => ['required', 'exists:uoms,name'],
            '*.quantity' => 'required',
            '*.tgl_bast' => 'required',
            '*.hm' => 'required',
            '*.pr_number' => 'required',
            '*.po_number' => 'required',
            '*.gr_number' => 'required',
            '*.remark' => 'required',
            '*.status' => ['required', 'in:' . implode(',', collect(Status::cases())->pluck('value')->toArray())],
        ];
        $validator = Validator::make($data, $rules);
        $validator->setException(ValidationException::withMessages($this->transform($validator->getMessageBag())));
        return $validator->valid();
    }

    public function transform(MessageBag $messages)
    {
        $results = [];
        foreach ($messages->getMessages() as $key => $value) {
            $keys = str($key)->explode('.');
            $field = ucwords(str(isset($keys[1]) ? $keys[1] : '')->replace('_', ' ')->value());
            $i = (isset($keys[0]) ? $keys[0] : 0) + 1;
            $results = array_merge($results, [$key => [
                $field . " baris ke-" . $i . str($value[0])->remove($key)->value()
            ]]);
        }
        return $results;
    }
}
