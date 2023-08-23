<?php

namespace App\Services\Sidebars;

use App\Services\Sidebars\Contracts\SidebarInterface;

class Sidebar
{
    public int $grandTotal = 0;

    public function totals()
    {
        $totals = [];
        foreach ($this->modules() as $key => $module) {
            $total = $this->total($module);
            $totals = array_merge($totals, [
                $key => $total
            ]);
            $this->grandTotal += $total;
        }
        return $totals;
    }

    private function total(SidebarInterface $sidebarInterface)
    {
        return $sidebarInterface->total();
    }

    private function modules()
    {
        return [
            'dispose' => new AssetDispose(),
            'request' => new AssetRequest(),
            'transfer' => new AssetTransfer(),
        ];
    }
}