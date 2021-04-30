<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

final class AnnouncementType extends Enum implements LocalizedEnum
{
    const Exam = 1;
    const Test = 2;
    const Exercise = 3;
    const Lesson = 4;
    const Other = 5;
}
