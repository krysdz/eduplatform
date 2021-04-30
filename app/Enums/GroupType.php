<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

final class GroupType extends Enum implements LocalizedEnum
{
    const Lecture = 1;
    const Practical = 2;
    const Laboratory = 3;
    const Workshop = 4;
    const ForeignLanguage = 5;
    const Seminar = 6;
    const Elearning = 7;
    const Exam = 8;
    const Internship = 9;
    const Tutorship = 10;
    const PhysicalEducation = 11;
}
