<?php

namespace App\Services\Cers;

use App\DataTransferObjects\Cers\CerData;
use App\Elasticsearch\QueryBuilder\Term;
use App\Enums\Workflows\Status;
use App\Facades\Elasticsearch;
use App\Helpers\AuthHelper;
use App\Helpers\Helper;
use App\Http\Requests\Cers\CerRequest;
use App\Models\Cers\Cer;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Project;
use App\Repositories\Cers\CerRepository;
use App\Services\API\HRIS\EmployeeService;
use App\Services\API\TXIS\CerService as TXISCerService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class CerService
{
    public function __construct(
        protected CerRepository $cerRepository,
        protected EmployeeService $employeeService,
    ) {
    }

    public function all($search = null)
    {
        $data = Elasticsearch::setModel(Cer::class)->searchMultipleQuery($search, terms: [
            new Term('nik', AuthHelper::getNik())
        ])->all();
        return CerData::collection(Arr::pluck($data, '_source'))->toCollection();
    }

    public function datatable()
    {
        return Cer::query()->get();
    }

    public function updateOrCreate(CerRequest $request, bool $isDraft = false)
    {
        $data = CerData::fromRequest($request, $isDraft);
        return DB::transaction(function () use ($data, $isDraft) {
            $cer = $this->cerRepository->updateOrCreate($data);
            if ($data->getKey()) {
                $cer->items()->delete();
                $cer->workflows()->delete();
            }
            $cer->items()->createMany($data->itemsToAttach());
            if (!$isDraft) {
                CerWorkflowService::setModel($cer)
                    ->setBarrier($data->grandTotal())
                    ->store();
            }
            $this->cerRepository->sendToElasticsearch($cer, $data->getKey());
            return $cer;
        });
    }

    public function delete(Cer $cer)
    {
        return DB::transaction(function () use ($cer) {
            $cer->items()->delete();
            $cer->workflows()->delete();
            $this->cerRepository->destroyFromElastic($cer);
            return $cer->delete();
        });
    }

    public function getListNoCerByUser(Request $request)
    {
        $employee = Employee::query()
            ->with('position')
            ->where('nik', $request->nik)
            ->orWhere('email_perusahaan', $request->email)
            ->first();
        return Cer::query()->where('status', Status::CLOSE)
            ->when($request->nik, function ($query, $nik) {
                $query->where('nik', $nik);
            })->when($request->email, function ($query, $email) use ($employee) {
                $query->with(['employee' => function ($query) use ($employee) {
                    $query->whereHas('position', function ($query) use ($employee) {
                        $query->where('dept_id', $employee->position?->dept_id);
                    });
                }]);
            })
            ->where('status_pr', false)
            ->pluck('no_cer');
    }

    public function update(Cer $cer, array $data)
    {
        return DB::transaction(function () use ($cer, $data) {
            $cer->update($data);
            $this->cerRepository->sendToElasticsearch($cer, $cer->getKey());
        });
    }

    public function findByNo($no)
    {
        $cer = Cer::query()->with('items.uom')->where('no_cer', str($no)->replace('_', '/')->value())->firstOrFail();
        return CerData::from($cer);
    }

    public static function getEmployee($nik = null): array
    {
        $token = UserService::getAdministrator()?->oatuhToken?->access_token;
        $nik = $nik ?? AuthHelper::getNik();
        $employee = (new EmployeeService)->setToken(auth()->check() ? null : $token)->getByNik($nik);
        return isset($employee['data']) ? $employee['data'] : [];
    }

    public static function getByCurrentApproval()
    {
        return Cer::query()
            ->where('status', Status::OPEN)
            ->whereHas('currentApproval', function ($query) {
                $query->where('nik', AuthHelper::getNik());
            })
            ->get();
    }

    public function getCerTxis($code)
    {
        $data = (new TXISCerService)->getByCode($code);
        return isset($data['data']) ? $data['data'] : [];
    }

    public static function nextNumber($projectPrefix)
    {
        $cer = Cer::select(['no_cer'])
            ->where('no_cer', 'like', "%/$projectPrefix/%")
            ->orderBy('no_cer', 'DESC')
            ->first();
        $lastKode = null;
        if ($cer) {
            $lastKode = str($cer?->no_cer)->explode('/')->first();
        }
        $prefix = 'CER';
        $length = 7;
        $prefixLength = strlen($prefix);
        $idLength = $length - $prefixLength;
        if (!$lastKode) {
            return $prefix . str_pad(1, $idLength, '0', STR_PAD_LEFT);
        }
        $maxId = substr($lastKode, $prefixLength + 1, $idLength);
        return $prefix . str_pad((int)$maxId + 1, $idLength, '0', STR_PAD_LEFT);
    }

    public static function nextNoCer($department_id, $nik)
    {
        $department = Department::select(['dept_code'])->where('dept_id', $department_id)->first();
        $project = Project::query()->whereHas('positions', function ($query) use ($nik) {
            $query->whereHas('employees', function ($query) use ($nik) {
                $query->where('nik', $nik);
            });
        })
            ->first();

        return collect([
            self::nextNumber($project->project_prefix),
            $department?->dept_code,
            $project?->project_prefix,
            Helper::getRomawi(now()->month),
            now()->year,
        ])->implode('/');
    }
}
