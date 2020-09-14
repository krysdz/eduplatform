<?php

namespace Database\Seeders;

use App\Models\Admin;
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
            'is_super_admin' => 1
        ])->first()->user()->update([
            'first_name' => 'Krystian',
            'last_name' => 'Dziewa',
            'email' => 'admin@eduplatform.pl',
            'password' => Hash::make('qwerty'),
        ]);

        Student::factory(10)->create();
        Teacher::factory(10)->create();
        $this->createTerms();
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
}
