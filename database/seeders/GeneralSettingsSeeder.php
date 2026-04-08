<?php

namespace Database\Seeders;

use App\Domain\Setting\GeneralSetting\Models\GeneralSetting;
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

        GeneralSetting::create();
    }
}
