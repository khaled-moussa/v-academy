<?php

namespace App\Support\Traits;

trait HasFormattedTimestamps
{
    /**
     * Auto-run when model boots
     */
    public function initializeHasFormattedTimestamps()
    {
        if (! in_array('created_at_formatted', $this->appends)) {
            $this->appends[] = 'created_at_formatted';
        }
    }

    /**
     * Get formatted created_at in user/app timezone
     */
    public function getCreatedAtFormattedAttribute(): ?string
    {
        if (! $this->created_at) {
            return null;
        }

        $timezone = 'Africa/Cairo';

        return $this->created_at
            ->copy()
            ->timezone($timezone)
            ->format('M d, Y h:i A');
    }
}
