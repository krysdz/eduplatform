<?php

namespace Database\Seeders;

use App\Enums\GroupTypeEnum;
use App\Models\Admin;
use App\Models\Course;
use App\Models\Faculty;
use App\Models\Group;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Term;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Admin::factory()->create([
            'is_super_admin' => 1,
            'is_active' => 1
        ])->first()->user()->update([
            'first_name' => 'Krystian',
            'last_name' => 'Dziewa',
            'email' => 'admin@eduplatform.pl',
            'password' => Hash::make('qwerty'),
        ]);

        Student::factory(30)->create();
        Teacher::factory(10)->create();
        $this->createTerms();
        $this->createFaculties();
        $this->createCourses();
        $this->createGroups();
    }

    private function createTerms()
    {
        $terms = [
            [
                'name' => 'Semestr zimowy 2019/2020',
                'start_date' => Date::create(2019, 10, 1),
                'end_date' => Date::create(2020, 1, 23),
                'is_active' => 0
            ],
            [
                'name' => 'Semestr letni 2019/2020',
                'start_date' => Date::create(2020, 1, 24),
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
            ],
        ];

        foreach ($groups as $group) {
            $currentGroup = Group::create($group);
            $currentGroup->students()->attach(Student::find([1,5,8,12,20]));
        }
    }
}
