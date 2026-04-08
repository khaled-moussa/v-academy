<?php

namespace App\Domain\Setting\GeneralSetting\Actions;

use App\Domain\Setting\GeneralSetting\Models\GeneralSetting;

class GetGeneralSettingAction
{
    public function execute(): ?GeneralSetting
    {
        return GeneralSetting::first();
    }
}
