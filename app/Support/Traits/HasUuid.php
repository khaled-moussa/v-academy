<?php

namespace App\Support\Traits;

use Illuminate\Support\Str;

trait HasUuid
{
    protected static function bootHasUuid(): void
    {
        static::creating(function ($model) {
            if (! $model->uuid) {
                $model->uuid = Str::random(16);
            }
        });
    }
}
