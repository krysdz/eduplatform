<?php

namespace App\Enums;

use Spatie\Enum\Laravel\Enum;

/**
 * @method static self exam()
 * @method static self test()
 * @method static self exercise()
 * @method static self class()
 * @method static self other()
 *
 */
final class AnnouncementTypeEnum extends Enum
{
    public static function makeFromId(int $id)
    {
        $value = array_flip(self::values())[$id];
        return self::make($value);
    }

    protected static function values(): array
    {
        return [
            'exam' => 1,
            'test' => 2,
            'exercise' => 3,
            'class' => 4,
            'other' => 5,
        ];
    }

    protected static function labels(): array
    {
        return [
            'exam' => 'Egzamin',
            'test' => 'Kolokwium',
            'exercise' => 'Zadanie',
            'class' => 'Zajęcia',
            'other' => 'Inne',
        ];
    }
}
