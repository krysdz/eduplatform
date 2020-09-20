<?php

namespace App\Enums;

use Spatie\Enum\Laravel\Enum;

/**
 * @method static self lecture()
 * @method static self class()
 * @method static self laboratoryClass()
 * @method static self workshop()
 * @method static self foreignLanguageClass()
 * @method static self seminar()
 * @method static self eLearning()
 * @method static self exam()
 * @method static self internship()
 * @method static self tutorship()
 * @method static self physicalExercises()
 *
 */
final class GroupTypeEnum extends Enum
{
    public static function makeFromId(int $id)
    {
        $value = array_flip(self::values())[$id];
        return self::make($value);
    }

    protected static function values(): array
    {
        return [
            'lecture' => 1,
            'class' => 2,
            'laboratoryClass' => 3,
            'workshop' => 4,
            'foreignLanguageClass' => 5,
            'seminar' => 6,
            'eLearning' => 7,
            'exam' => 8,
            'internship' => 9,
            'tutorship' => 10,
            'physicalExercises' => 11
        ];
    }

    protected static function labels(): array
    {
        return [
            'lecture' => 'Wykład',
            'class' => 'Ćwiczenia',
            'laboratoryClass' => 'Laboratorium',
            'workshop' => 'Pracownia',
            'foreignLanguageClass' => 'Lektorat',
            'seminar' => 'Proseminarium',
            'eLearning' => 'Kształcenie na odległość',
            'exam' => 'Egzamin',
            'internship' => 'Praktyka',
            'tutorship' => 'Konsultacje',
            'physicalExercises' => 'Wychowanie fizyczne'
        ];
    }
}
