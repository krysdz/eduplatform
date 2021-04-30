<?php

use App\Enums\AnnouncementType;
use App\Enums\AttendanceType;
use App\Enums\DayOfWeekType;
use App\Enums\GroupMemberType;
use App\Enums\GroupType;
use App\Enums\LessonStateType;
use App\Enums\UserRoleType;

return [

    AnnouncementType::class => [
        AnnouncementType::Exam => 'Egzamin',
        AnnouncementType::Test => 'Kolokwium',
        AnnouncementType::Exercise => 'Zadanie',
        AnnouncementType::Lesson => 'Zajęcia',
        AnnouncementType::Other => 'Inne',
    ],

    AttendanceType::class => [
        AttendanceType::Presence => 'Obecność',
        AttendanceType::Absence => 'Nieobecność',
        AttendanceType::Excused => 'Usprawiedliwiona nieobecność',
        AttendanceType::Late => 'Spóźnienie',
    ],

    DayOfWeekType::class => [
        DayOfWeekType::Monday => 'Poniedziałek',
        DayOfWeekType::Tuesday => 'Wtorek',
        DayOfWeekType::Wednesday => 'Środa',
        DayOfWeekType::Thursday => 'Czwartek',
        DayOfWeekType::Friday => 'Piątek',
        DayOfWeekType::Saturday => 'Sobota',
        DayOfWeekType::Sunday => 'Niedziela',
    ],

    GroupMemberType::class => [
        GroupMemberType::Teacher => 'Nauczyciel',
        GroupMemberType::Student => 'Student',
    ],

    GroupType::class => [
        GroupType::Lecture => 'Wykład',
        GroupType::Practical => 'Ćwiczenia',
        GroupType::Laboratory => 'Laboratorium',
        GroupType::Workshop => 'Pracownia',
        GroupType::ForeignLanguage => 'Lektorat',
        GroupType::Seminar => 'Proseminarium',
        GroupType::Elearning => 'Kształcenie na odległość',
        GroupType::Exam => 'Egzamin',
        GroupType::Internship => 'Praktyka',
        GroupType::Tutorship => 'Konsultacje',
        GroupType::PhysicalEducation => 'Wychowanie fizyczne',
    ],

    LessonStateType::class => [],

    UserRoleType::class => [
        UserRoleType::SuperAdministrator => 'Super administrator',
        UserRoleType::Administrator => 'Administrator',
        UserRoleType::Teacher => 'Nauczyciel',
        UserRoleType::Student => 'Student',
    ],

];
