<?php

namespace App\Filament\Components\Button;

use Closure;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\Size;

class GroupedActionsButton
{
    /**
     * Create grouped actions with optional custom actions.
     */
    public static function actions(
        bool|Closure $canView = true,
        bool|Closure $canEdit = true,
        bool|Closure $canDelete = true,
        array $extraActions = [],
    ): array|ActionGroup|null {

        $actions = [];

        /*
        |-------------------------------
        | Can View
        |-------------------------------
        */
        if ($canView) {
            $actions[] = ViewAction::make();
        }

        /*
        |-------------------------------
        | Can Edit
        |-------------------------------
        */
        if ($canEdit) {
            $actions[] = EditAction::make();
        }

        /*
        |-------------------------------
        | Extra Actions
        |-------------------------------
        */
        $actions = [
            ActionGroup::make($actions)->dropdown(false),
            ...$extraActions,
        ];

        /*
        |-------------------------------
        | Can Delete
        |-------------------------------
        */
        if ($canDelete) {
            $actions[] = ActionGroup::make([
                DeleteAction::make(),
            ])->dropdown(false);
        }

        return match (count($actions)) {
            0 => null,
            1 => [$actions[0]],
            default => ActionGroup::make($actions)
                ->label(__('Actions'))
                ->size(Size::Small)
                ->color(Color::Stone)
                ->button(),
        };
    }
}
