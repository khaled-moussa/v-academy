<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Domain\User\Models\User;
use App\Support\Enums\GenderEnum;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |-------------------------------
        | Admin Users Data
        |-------------------------------
        */

        $admins = [
            [
                'first_name' => 'Khaled',
                'last_name'  => 'Moussa',
                'gender'     => GenderEnum::MALE->value,
                'email'      => 'khaledmoussaeid@gmail.com',
            ],
        ];

        /*
        |-------------------------------
        | Create Users
        |-------------------------------
        */

        foreach ($admins as $admin) {
            User::firstOrCreate(
                ['email' => $admin['email']],
                [
                    'first_name' => $admin['first_name'],
                    'last_name'  => $admin['last_name'],
                    'gender'    => $admin['gender'],
                    'panel'      => 'admin',
                    'password'   => Hash::make('12345test'),
                    'email_verified_at' => now(),
                ]
            );
        }
    }
}
