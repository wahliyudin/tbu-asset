<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Http\Requests\Masters\ActivityRequest;
use App\Models\Masters\Activity;
use App\Services\Masters\ActivityService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ActivityController extends Controller
{
    public function __construct(
        private ActivityService $service
    ) {
    }

    public function index()
    {
        return view('masters.activity.index');
    }

    public function datatable()
    {
        return DataTables::of($this->service->all())
            ->editColumn('name', function ($activity) {
                return $activity->name;
            })
            ->editColumn('action', function ($activity) {
                return view('masters.activity.action', compact('activity'))->render();
            })
            ->rawColumns(['action'])
            ->make();
    }

    public function store(ActivityRequest $request)
    {
        try {
            $this->service->updateOrCreate($request);
            return response()->json([
                'message' => 'Berhasil disimpan'
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function edit(Activity $activity)
    {
        try {
            return response()->json($activity);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function destroy(Activity $activity)
    {
        try {
            $this->service->delete($activity);
            return response()->json([
                'message' => 'Berhasil dihapus'
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
