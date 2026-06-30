<?php

namespace App\Domain\Program\Models;

use App\Domain\Program\Models\Builders\ProgramBuilder;
use App\Domain\Program\Models\Relations\HasProgramRelation;
use App\Support\Traits\HasFormattedTimestamps;
use App\Support\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Vite;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Program extends Model implements HasMedia
{
    use HasUuid;
    use InteractsWithMedia;
    use HasFormattedTimestamps;
    use HasProgramRelation;

    /*
    |--------------------------------------------------------------------------
    | Properties
    |--------------------------------------------------------------------------
    */

    protected $guarded = [];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | Custom Query Builder
    |--------------------------------------------------------------------------
    */

    public function newEloquentBuilder($query): ProgramBuilder
    {
        return new ProgramBuilder($query);
    }

    /*
    |--------------------------------------------------------------------------
    |  Attributes
    |--------------------------------------------------------------------------
    */

    public function getCoverAttribute(): ?string
    {
        return $this->getFirstMediaUrl('cover') ?: Vite::asset('resources/assets/images/branding/logo-main.png');
    }

    public function getFileAttribute(): ?string
    {
        return $this->getFirstMediaUrl('programs');
    }

    public function getPreviewFileAttribute(): ?string
    {
        return $this->getFirstMediaUrl('programs') . '#toolbar=0&navpanes=0&scrollbar=0';
    }


    /*
    |--------------------------------------------------------------------------
    |  Media Register
    |--------------------------------------------------------------------------
    */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('programs')->singleFile();
    }

    /*
    |--------------------------------------------------------------------------
    | Getters
    |--------------------------------------------------------------------------
    */

    public function getId(): int
    {
        return $this->id;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getCreatedAt(): Carbon
    {
        return $this->created_at;
    }

    public function getUpdatedAt(): Carbon
    {
        return $this->updated_at;
    }

    /*
    |--------------------------------------------------------------------------
    | States
    |--------------------------------------------------------------------------
    */

    public function isActive(): bool
    {
        return $this->is_active;
    }
}
