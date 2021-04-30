<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

final class AttendanceType extends Enum implements LocalizedEnum
{
    const Presence = 1;
    const Absence = 2;
    const Excused = 3;
    const Late = 4;
}
