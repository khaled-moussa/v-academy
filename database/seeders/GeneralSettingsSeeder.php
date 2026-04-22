<?php

namespace Database\Seeders;

use App\Domain\Setting\GeneralSetting\Actions\UpdateGeneralSettingAction;
use App\Domain\Setting\GeneralSetting\Dtos\GeneralSettingDto;
use Illuminate\Database\Seeder;

class GeneralSettingsSeeder extends Seeder
{
    public function run(): void
    {

        /*
        |-------------------------------
        | Create Default General Setting
        |-------------------------------
        */

        $dto = new GeneralSettingDto(
            siteName: config('company-info.site_name'),
            tagline: config('company-info.tagline'),
            slugon: config('company-info.slugon'),
            description: config('company-info.description'),
            address: config('company-info.address'),
            locationUrl: config('company-info.location_url'),
            supportEmail: config('company-info.support_email'),
            phones: config('company-info.phones', []),
        );

        app(UpdateGeneralSettingAction::class)->execute($dto);
    }
}
