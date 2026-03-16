<?php

namespace App\Enums;

enum ChangeFrequency: string
{
    case DAILY = 'Daily';
    case WEEKLY = 'Weekly';
    case MONTHLY = 'Monthly';
    case YEARLY = 'Yearly';

    // Helper to get labels for dropdowns
    public static function labels(): array
    {
        return array_combine(
            array_column(self::cases(), 'value'),
            array_column(self::cases(), 'value')
        );
    }
}

