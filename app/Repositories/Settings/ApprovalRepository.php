<?php

namespace App\Repositories\Settings;

use App\DataTransferObjects\Settings\ApprovalDto;
use App\Enums\Settings\Approval;
use App\Enums\Workflows\Module;
use App\Models\Settings\SettingApproval;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Collection;

class ApprovalRepository
{
    public static function getAtasanLangsung(User $user)
    {
    }

    public static function getDirector()
    {
    }

    public static function getGeneralManager()
    {
    }

    public static function getDepartmentHead(User $user)
    {
    }

    public static function getProjectOwner(User $user)
    {
    }

    public static function getFinance()
    {
    }

    public static function getHCA(User $user)
    {
    }

    public static function getGeneralManagerOperation()
    {
    }

    public static function logicApproval(Approval $approval)
    {
        return match ($approval) {
            Approval::ATASAN_LANGSUNG => function () {
                $atasanLangsung = self::getAtasanLangsung(auth()->user());
                if (!$atasanLangsung) {
                    throw new Exception('Anda belum mempunyai Atasan Langsung');
                }
                return $atasanLangsung;
            },
            Approval::DIRECTOR => function () {
                $director = self::getDirector();
                if (!$director) {
                    throw new Exception('Anda belum mempunyai Director');
                }
                return $director;
            },
            Approval::GENERAL_MANAGER => function () {
                $generalManager = self::getGeneralManager();
                if (!$generalManager) {
                    throw new Exception('Anda belum mempunyai GENERAL MANAGER SUPPLY CHAIN & ADMINISTRATION');
                }
                return $generalManager;
            },
            Approval::DEPARTMENT_HEAD => function () {
                $departmentHead = self::getDepartmentHead(auth()->user());
                if (!$departmentHead) {
                    throw new Exception('Anda belum mempunyai Department Head');
                }
                return $departmentHead;
            },
            Approval::PROJECT_OWNER => function () {
                $projectOwner = self::getProjectOwner(auth()->user());
                if (!$projectOwner) {
                    throw new Exception('Anda belum mempunyai Project Owner');
                }
                return $projectOwner;
            },
            Approval::FINANCE => function () {
                $finance = self::getFinance();
                if (!$finance) {
                    throw new Exception('Anda belum mempunyai Finance');
                }
                return $finance;
            },
            Approval::HCA => function () {
                $hca = self::getHCA(auth()->user());
                if (!$hca) {
                    throw new Exception('Anda belum mempunyai HCA');
                }
                return $hca;
            },
            Approval::GENERAL_MANAGER_OPERATION => function () {
                $generalManagerOperation = self::getGeneralManagerOperation();
                if (!$generalManagerOperation) {
                    throw new Exception('Anda belum mempunyai General Manager Operation');
                }
                return $generalManagerOperation;
            },
            default => null
        };
    }

    /**
     * @param ApprovalDto $dto
     *
     * @return mixed
     */
    public static function updateOrCreate(ApprovalDto $dto): mixed
    {
        for ($i = 0; $i < count($dto->data ?? []); $i++) {
            if (isset($dto->data[$i])) {
                SettingApproval::query()->updateOrCreate([
                    'id' => $dto->data[$i]['key'],
                ], [
                    'module' => $dto->module,
                    'approval' => $dto->data[$i]['approval'],
                    'title' => $dto->data[$i]['title'],
                    'nik' => $dto->data[$i]['nik'],
                ]);
            }
        }
        return SettingApproval::query()
            ->where('module', $dto->module)
            ->whereNotIn('id', $dto->keys)
            ->delete();
    }

    /**
     * @param Module $module
     *
     * @return Collection
     */
    public static function getByModule(Module $module): Collection
    {
        return SettingApproval::query()->where('module', $module)->get();
    }

    /**
     * @return Collection
     */
    public static function all(): Collection
    {
        return SettingApproval::query()->select(['id', 'module', 'approval', 'nik', 'title'])->get();
    }

    /**
     * @return array
     */
    public static function dataForView(): array
    {
        $settingApprovals = self::all();
        $results = [];
        foreach (Module::cases() as $key => $module) {
            $tmp = $settingApprovals->where('module', $module);
            $results = array_merge($results, [
                $module->value => [
                    'module' => $module->value,
                    'childs' => $tmp
                ],
            ]);
        }
        return $results;
    }
}
