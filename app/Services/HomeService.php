<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class HomeService
{
    public static function assetByCategory()
    {
        return DB::table('categories')
            ->select(['categories.name as category', DB::raw('COUNT(assets.id) as value')])
            ->leftJoin('clusters', 'clusters.category_id', '=', 'categories.id')
            ->leftJoin('sub_clusters', 'sub_clusters.cluster_id', '=', 'clusters.id')
            ->leftJoin('assets', 'assets.sub_cluster_id', '=', 'sub_clusters.id')
            ->groupBy('categories.name')
            ->get();
    }

    public static function assetByCategoryBookValue()
    {
        return DB::table('categories')
            ->select(['categories.name as category', DB::raw('SUM(asset_leasings.harga_beli) as value')])
            ->leftJoin('clusters', 'clusters.category_id', '=', 'categories.id')
            ->leftJoin('sub_clusters', 'sub_clusters.cluster_id', '=', 'clusters.id')
            ->leftJoin('assets', 'assets.sub_cluster_id', '=', 'sub_clusters.id')
            ->leftJoin('asset_leasings', 'asset_leasings.asset_id', '=', 'assets.id')
            ->groupBy('categories.name')
            ->get();
    }
}
