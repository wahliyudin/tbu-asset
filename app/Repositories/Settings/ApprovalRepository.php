<?php

namespace App\Repositories\Settings;

use App\DataTransferObjects\Settings\ApprovalDto;
use App\Enums\Workflows\Module;
use App\Models\Settings\SettingApproval;
use Illuminate\Database\Eloquent\Collection;

class ApprovalRepository
{
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
                    'title' => $module->label(),
                    'module' => $module->value,
                    'childs' => $tmp
                ],
            ]);
        }
        return $results;
    }
}
