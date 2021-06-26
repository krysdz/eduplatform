<?php

namespace Database\Seeders;

use App\Enums\GroupMemberType;
use App\Enums\GroupType;
use App\Enums\UserRoleType;
use App\Models\Course;
use App\Models\Faculty;
use App\Models\Group;
use App\Models\GroupSchedule;
use App\Models\Term;
use App\Models\UserRole;
use Faker\Generator;
use Illuminate\Container\Container;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    public Generator $faker;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->faker = Container::getInstance()->make(Generator::class);

        Storage::deleteDirectory('files');

        $this->createSuperAdministrator();
        $this->createAdministrators();
        $teachers = $this->createTeachers();
        $students = $this->createStudents();

        $this->createTerms();
        $this->createFaculties();
        $this->createCourses($teachers);
        $this->createGroups($teachers, $students);
    }

    private function createSuperAdministrator(): void
    {
        UserRole::factory()->create([
            'type' => UserRoleType::SuperAdministrator,
        ])->first()->user()->update([
            'first_name' => 'Krystian',
            'last_name' => 'Dziewa',
            'email' => 'admin@example.com',
        ]);
    }

    private function createAdministrators(): void
    {
        UserRole::factory(2)->create([
            'type' => UserRoleType::Administrator,
        ]);
    }

    private function createTeachers(): Collection
    {
        return UserRole::factory(10)->create([
            'type' => UserRoleType::Teacher,
        ]);
    }

    private function createStudents(): Collection
    {
        return UserRole::factory(30)->create([
            'type' => UserRoleType::Student,
        ]);
    }

    private function createTerms()
    {
        $terms = [
            [
                'name' => 'Semestr zimowy 2020/2021',
                'code' => '20/21Z',
                'start_date' => Date::create(2020, 10, 1),
                'end_classes_date' => Date::create(2021, 1, 28),
                'end_date' => Date::create(2021, 2, 24),
            ],
            [
                'name' => 'Semestr letni 2020/2021',
                'code' => '20/21L',
                'start_date' => Date::create(2021, 2, 25),
                'end_classes_date' => Date::create(2021, 6, 15),
                'end_date' => Date::create(2021, 9, 30),
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

    private function createCourses($teachers)
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
                'faculty_id' => Faculty::where(['code' => 'UJ.WMi'])->first()->id,
            ],
            [
                'name' => 'Logika i teoria mnogości',
                'code' => 'WMI.II-LiTM-1SO',
                'faculty_id' => Faculty::where(['code' => 'UJ.WMI'])->first()->id,
            ]
        ];

        foreach ($courses as $course) {
            Course::create(array_merge(['coordinator_id' => $teachers->random()->id], $course));
        }
    }

    private function createGroups($teachers, $students)
    {
        $groups = [
            [
                'number' => 1,
                'type' => GroupType::Lecture,
                'course_id' => Faculty::first()->id,
                'term_id' => Term::where(['code' => '20/21L'])->first()->id,
            ],
            [
                'number' => 2,
                'type' => GroupType::Practical,
                'course_id' => Faculty::first()->id,
                'term_id' => Term::where(['code' => '20/21L'])->first()->id,
            ],
        ];

        foreach ($groups as $group) {
            $currentGroup = Group::create($group);
            $currentGroup->groupMembers()->attach($students->random(7), ['type' => GroupMemberType::Student]);
            $currentGroup->groupMembers()->attach($teachers->random(2), ['type' => GroupMemberType::Teacher]);

            GroupSchedule::factory(rand(1,3))->create([
                'group_id' => $currentGroup,
                'teacher_id' => $currentGroup->teachers()->first()->id,
                'first_date' => $this->faker->dateTimeInInterval($currentGroup->term->start_date, '+'.rand(0,30).'days'),
                'last_date' => $this->faker->dateTimeInInterval($currentGroup->term->end_classes_date, '-'.rand(0,30).'days'),
            ]);


//            (new \App\Http\Controllers\Admin\GroupController)->generateLessons($currentGroup);
        }
    }


}
