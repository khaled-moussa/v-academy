<?php

namespace App\Filament\Components\Button;

use Illuminate\Support\HtmlString;
use Illuminate\Support\Facades\Blade;

class WizardSubmitActionButton
{
    public static function submit(
        string $label = 'Submit',
        string $action = 'create',
        $livewire = null
    ): HtmlString {
        $blade = <<<BLADE
            @if (\$livewire && \$livewire->getOperation() !== 'edit')
                <x-filament::button
                    type="submit"
                    size="sm"
                    wire:click="{$action}"
                    wire:loading.attr="disabled"
                    wire:target="{$action}"
                >
                    {$label}
                </x-filament::button>
            @endif
        BLADE;

        return new HtmlString(Blade::render($blade, [
            'livewire' => $livewire,
        ]));
    }
}