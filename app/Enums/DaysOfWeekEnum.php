<?php

namespace App\Enums;

use Spatie\Enum\Laravel\Enum;

/**
 * @method static self monday()
 * @method static self tuesday()
 * @method static self wednesday()
 * @method static self thursday()
 * @method static self friday()
 * @method static self saturday()
 * @method static self sunday()
 *
 */
final class DaysOfWeekEnum extends Enum
{
    public static function makeFromId(int $id)
    {
        $value = array_flip(self::values())[$id];
        return self::make($value);
    }

    protected static function values(): array
    {
        return [
            'monday' => 1,
            'tuesday' => 2,
            'wednesday' => 3,
            'thursday' => 4,
            'friday' => 5,
            'saturday' => 6,
            'sunday' => 0,
        ];
    }

    protected static function labels(): array
    {
        return [
            'monday' => 'poniedziałek',
            'tuesday' => 'wtorek',
            'wednesday' => 'środa',
            'thursday' => 'czwartek',
            'friday' => 'piątek',
            'saturday' => 'sobota',
            'sunday' => 'niedziela',
        ];
    }
}
