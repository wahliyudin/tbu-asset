<?php

namespace App\Http\Controllers;

use App\Services\GlobalService;
use App\Services\Sidebars\Sidebar;

class GlobalController extends Controller
{
    public function totalApprovals()
    {
        try {
            $sidebar = new Sidebar();
            $totals = $sidebar->totals();
            $grandTotal = $sidebar->grandTotal;
            return response()->json(array_merge(['grand_total' => $grandTotal], $totals));
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function projectDataForSelect()
    {
        try {
            $data = GlobalService::getProjects();
            return response()->json($data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function employeeDataForSelect()
    {
        try {
            $data = GlobalService::getEmployees(['nik', 'nama_karyawan'])->toCollection();
            return response()->json($data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
