<?php

namespace App\Http\Controllers;

use App\DataTransferObjects\Cers\CerDto;
use App\DataTransferObjects\Example;
use App\Http\Resources\Cers\CerResource;
use App\Models\Cers\Cer;
use App\Models\Masters\Category;
use App\Models\Masters\Cluster;
use App\Services\API\HRIS\EmployeeService;
use App\Services\UserService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }
}