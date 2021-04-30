<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

final class GroupMemberType extends Enum implements LocalizedEnum
{
    const Teacher = 1;
    const Student = 2;
}
