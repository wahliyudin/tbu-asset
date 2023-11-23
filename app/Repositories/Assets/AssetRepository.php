<?php

namespace App\Repositories\Assets;

use App\DataTransferObjects\Assets\AssetData;
use App\Enums\Asset\Status;
use App\Models\Assets\Asset;
use App\Models\Employee;
use App\Models\Project;

class AssetRepository
{
    public function all()
    {
        return Asset::query()->with(['assetUnit.unit', 'leasing', 'insurance', 'project'])->get();
    }

    public function updateOrCreate(AssetData $data)
    {
        return Asset::query()->updateOrCreate([
            'id' => $data->key
        ], $data->toArray());
    }

    public function instance()
    {
        return Asset::query()->with(['project', 'employee', 'assetUnit.unit']);
    }

    public function nikEmployees($search)
    {
        return Employee::select('nik')->where('nama_karyawan', 'like', "%$search%")->pluck('nik');
    }

    public function idProjects($search)
    {
        return Project::select('project_id')->where('project', 'like', "%$search%")->pluck('project_id');
    }

    public function applySearchFilters($searchTerm, $query)
    {
        if (!empty($searchTerm)) {
            $niks = $this->nikEmployees($searchTerm);
            $projects = $this->idProjects($searchTerm);

            $query->where(function ($q) use ($searchTerm, $niks, $projects) {
                $q->where('kode', 'like', "%$searchTerm")
                    ->orWhereHas('assetUnit', function ($q) use ($searchTerm) {
                        $q->where('kode', 'like', "%$searchTerm")
                            ->orWhereHas('unit', function ($q) use ($searchTerm) {
                                $q->where('model', 'like', "%$searchTerm");
                            })
                            ->orWhere('type', 'like', "%$searchTerm");
                    })
                    ->orWhereIn('pic', $niks->toArray())
                    ->orWhereIn('asset_location', $projects->toArray());
            });
        }

        return $query;
    }

    public function findById($id)
    {
        return Asset::query()->with([
            'assetUnit.unit',
            'subCluster.cluster.category', 'department',
            'insurance',
            'leasing',
            'uom', 'lifetime', 'activity', 'condition'
        ])->find($id);
    }

    public function findByKode($kode)
    {
        return Asset::query()
            ->with([
                'assetUnit.unit',
                'subCluster.cluster.category',
                'department',
                'insurance',
                'leasing.dealer',
                'leasing.leasing',
                'uom',
                'lifetime',
                'activity',
                'condition',
                'employee.position' => function ($query) {
                    $query->with([
                        'divisi',
                        'project',
                        'department',
                    ]);
                }
            ])
            ->where('kode', $kode)
            ->first();
    }

    public function getByStatus(Status $status)
    {
        return Asset::query()->where('status', $status)->get();
    }

    public function dataForEditById($id)
    {
        return Asset::query()->with(['assetUnit', 'leasing', 'insurance'])->findOrFail($id);
    }

    public function insertByImport($data)
    {
        return Asset::query()->create([
            'kode' => $data['kode'],
            'asset_unit_id' => $data['asset_unit_id'],
            'sub_cluster_id' => $data['sub_cluster_id'],
            'pic' => $data['pic'],
            'activity_id' => $data['activity_id'],
            'asset_location' => $data['asset_location'],
            'dept_id' => $data['dept_id'],
            'condition_id' => $data['condition_id'],
            'lifetime_id' => $data['lifetime_id'],
            'uom_id' => $data['uom_id'],
            'quantity' => $data['quantity'],
            'nilai_sisa' => $data['nilai_sisa'],
            'tgl_bast' => $data['tgl_bast'],
            'hm' => $data['hm'],
            'pr_number' => $data['pr_number'],
            'po_number' => $data['po_number'],
            'gr_number' => $data['gr_number'],
            'remark' => $data['remark'],
            'status_asset' => $data['status_asset'],
            'status' => $data['status'],
        ]);
    }

    public function getWithAllRelations()
    {
        return Asset::query()->with([
            'assetUnit.unit',
            'subCluster.cluster.category',
            'department',
            'depreciations',
            'depreciation',
            'insurance',
            'leasing',
            'uom',
            'lifetime',
            'activity',
            'condition',
            'project',
            'department'
        ])->get();
    }
}
