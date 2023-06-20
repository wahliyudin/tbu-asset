<?php

namespace App\Repositories\Settings;

use App\Enums\Settings\Approval;
use App\Enums\Workflows\Module;
use App\Models\Settings\SettingApproval;
use App\Models\User;
use Exception;

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

    public static function updateOrCreate(array $data, Module $module)
    {
        for ($i = 0; $i < count($data); $i++) {
            if (isset($data[$i])) {
                SettingApproval::query()->updateOrCreate([
                    'id' => $data[$i]['key'],
                ], [
                    'module' => $module,
                    'approval' => $data[$i]['approval'],
                    'title' => $data[$i]['title'],
                    'nik' => $data[$i]['nik'],
                ]);
            }
        }
        $ids = collect($data)->pluck('key')->values()->toArray();
        return SettingApproval::query()
            ->where('module', $module)
            ->whereNotIn('id', $ids)
            ->delete();
    }

    public static function getByModule(Module $module)
    {
        return SettingApproval::query()->where('module', $module)->get();
    }
}
