<?php

namespace App\Support\Traits;

use App\Domain\Support\Casts\UserTimezoneCast;

trait HasDatetimeCast
{
    protected function casts(): array
    {
        return [
            'created_at' => UserTimezoneCast::class,
            'updated_at' => UserTimezoneCast::class,
        ];
    }
}
