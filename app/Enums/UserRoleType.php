<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

final class UserRoleType extends Enum implements LocalizedEnum
{
    const SuperAdministrator = 1;
    const Administrator = 2;
    const Teacher = 3;
    const Student = 4;

    public static function asArrayWithoutSuper(): array
    {
        $array = UserRoleType::getConstants();
        unset($array['SuperAdministrator']);

        return $array;
    }
}
