<?php

namespace App\Enums;

use Spatie\Enum\Laravel\Enum;

/**
 * @method static self presence()
 * @method static self absence()
 * @method static self excusedAbsence()
 * @method static self tardy()
 */
final class AttendanceTypeEnum extends Enum
{
    public static function makeFromId(int $id)
    {
        $value = array_flip(self::values())[$id];
        return self::make($value);
    }

    protected static function values(): array
    {
        return [
            'presence' => 1,
            'absence' => 2,
            'excusedAbsence' => 3,
            'tardy' => 4,
        ];
    }

    protected static function labels(): array
    {
        return [
            'presence' => 'O',
            'absence' => 'N',
            'excusedAbsence' => 'U',
            'tardy' => 'S',
        ];
    }
}
