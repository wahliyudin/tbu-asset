<?php

namespace App\Http\Controllers;

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
}
