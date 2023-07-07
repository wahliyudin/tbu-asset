<?php

namespace App\Http\Controllers;

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