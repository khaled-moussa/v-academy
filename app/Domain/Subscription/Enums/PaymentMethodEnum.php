<?php

namespace App\Domain\Subscription\Enums;

enum PaymentMethodEnum: string
{
    case INSTAPAY = 'instapay';
    case VODAFONE_CASH = 'vodafone_cash';

    public function label(): string
    {
        return match ($this) {
            self::INSTAPAY => 'Instapay',
            self::VODAFONE_CASH => 'Vodafone Cash',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::INSTAPAY => 'indigo',
            self::VODAFONE_CASH => 'danger',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function options(): array
    {
        return array_combine(
            array_column(self::cases(), 'value'),
            array_map(fn($case) => $case->label(), self::cases())
        );
    }

    public static function colorOptions(): array
    {
        return array_combine(
            array_column(self::cases(), 'value'),
            array_map(fn($case) => $case->color(), self::cases())
        );
    }
}
