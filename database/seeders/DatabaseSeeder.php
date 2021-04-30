<?php

namespace Database\Seeders;

use App\Enums\DayOfWeekType;
use App\Enums\GroupTypeEnum;
use App\Enums\UserRoleType;
use App\Models\Course;
use App\Models\Faculty;
use App\Models\Group;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Term;
use App\Models\UserRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Storage::deleteDirectory('files');

        $this->createSuperAdministrator();
        $this->createAdministrators();
        $this->createTeachers();
        $this->createStudents();

//        $this->createTerms();
//        $this->createFaculties();
//        $this->createCourses();
//        $this->createGroups();
    }

    private function createSuperAdministrator(): void
    {
        UserRole::factory()->create([
            'role_type' => UserRoleType::SuperAdministrator,
        ])->first()->user()->update([
            'first_name' => 'Krystian',
            'last_name' => 'Dziewa',
            'email' => 'admin@example.com',
        ]);
    }

    private function createAdministrators(): void
    {
        UserRole::factory(2)->create([
            'role_type' => UserRoleType::Administrator,
        ]);
    }

    private function createTeachers(): void
    {
        UserRole::factory(10)->create([
            'role_type' => UserRoleType::Teacher,
        ]);
    }

    private function createStudents(): void
    {
        UserRole::factory(30)->create([
            'role_type' => UserRoleType::Student,
        ]);
    }

    private function createTerms()
    {
        $terms = [
            [
                'name' => 'Semestr zimowy 2019/2020',
                'code' => '19/20Z',
                'start_date' => Date::create(2019, 10, 1),
                'end_classes_date' => Date::create(2020, 1, 28),
                'end_date' => Date::create(2020, 2, 23),
                'is_active' => 0
            ],
            [
                'name' => 'Semestr letni 2019/2020',
                'code' => '19/20L',
                'start_date' => Date::create(2020, 2, 24),
                'end_classes_date' => Date::create(2020, 6, 14),
                'end_date' => Date::create(2020, 9, 30),
                'is_active' => 1
            ]
        ];

        foreach ($terms as $term) {
            Term::create($term);
        }
    }

    private function createFaculties()
    {
        $faculties = [
            [
                'name' => 'Wydział Matematyki i Informatyki',
                'code' => 'UJ.WMI'
            ],
            [
                'name' => 'Wydział Fizyki, Astronomii i Informatyki Stosowanej',
                'code' => 'UJ.WFAI'
            ]
        ];

        foreach ($faculties as $faculty) {
            Faculty::create($faculty);
        }
    }

    private function createCourses()
    {
        $courses = [
            [
                'name' => 'Interfejsy graficzne',
                'code' => 'WFAIS.IF-X201.0',
                'faculty_id' => Faculty::where(['code' => 'UJ.WFAI'])->first()->id,
            ],
            [
                'name' => 'Bazy danych',
                'code' => 'WFAIS.IF-K104.0',
                'faculty_id' => Faculty::where(['code' => 'UJ.WFAI'])->first()->id,
            ],
            [
                'name' => 'Algorytmy i struktury danych',
                'code' =>  	'WMI.II-ASD-OL',
                'faculty_id' => Faculty::where(['code' => 'UJ.wMi'])->first()->id,
            ],
            [
                'name' => 'Logika i teoria mnogości',
                'code' => 'WMI.II-LiTM-1SO',
                'faculty_id' => Faculty::where(['code' => 'UJ.WMI'])->first()->id,
            ]
        ];

        foreach ($courses as $course) {
            Course::create($course);
        }
    }

    private function createGroups()
    {
        $groups = [
            [
                'number' => 1,
                'type' => GroupTypeEnum::lecture()->value,
                'teacher_id' => Teacher::first()->id,
                'course_id' => Faculty::first()->id,
                'term_id' => Term::where(['is_active' => true])->first()->id,
                'day_of_classes' => DayOfWeekType::monday()->value
            ],
            [
                'number' => 2,
                'type' => GroupTypeEnum::class()->value,
                'teacher_id' => Teacher::find(5)->id,
                'course_id' => Faculty::first()->id,
                'term_id' => Term::where(['is_active' => true])->first()->id,
                'day_of_classes' => DayOfWeekType::friday()->value
            ],
        ];

        foreach ($groups as $group) {
            $currentGroup = Group::create($group);
            $currentGroup->students()->attach(Student::find([1,5,8,12,20]));

            (new \App\Http\Controllers\Admin\GroupController)->generateLessons($currentGroup);
        }
    }


}
