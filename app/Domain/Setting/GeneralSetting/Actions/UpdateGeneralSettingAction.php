<?php

namespace App\Domain\Setting\GeneralSetting\Actions;

use App\Domain\Setting\GeneralSetting\Dtos\GeneralSettingDto;
use App\Domain\Setting\GeneralSetting\Models\GeneralSetting;

class UpdateGeneralSettingAction
{
    public function execute(GeneralSettingDto $dto): GeneralSetting
    {
        $generalSetting = GeneralSetting::first();

        if (! $generalSetting) {
            return GeneralSetting::create($dto->toArray());
        }

        $generalSetting->update($dto->toArray());

        return $generalSetting->refresh();
    }
}