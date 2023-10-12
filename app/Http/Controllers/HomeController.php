<?php

namespace App\Http\Controllers;

use App\DataTransferObjects\Masters\CategoryData;
use App\Elasticsearch\BodyBuilder\Body;
use App\Elasticsearch\BodyBuilder\Document;
use App\Elasticsearch\BodyBuilder\Index;
use App\Elasticsearch\Implement;
use App\Elasticsearch\QueryBuilder\Query;
use App\Elasticsearch\QueryBuilder\Range;
use App\Facades\Elasticsearch;
use App\Models\Masters\Category;
use App\Services\HomeService;

class HomeController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }

    public function charts()
    {
        try {
            return response()->json([
                'assetByCategory' => HomeService::assetByCategory(),
                'assetByCategoryBookValue' => HomeService::assetByCategoryBookValue()
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
