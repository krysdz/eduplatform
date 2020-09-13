<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Seeder;
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
             'isSuperAdmin' => 1
         ])->first()->user()->update([
             'first_name' => 'Krystian',
             'last_name' => 'Dziewa',
             'email' => 'admin@eduplatform.pl',
             'password' => Hash::make('qwerty'),
         ]);

         Student::factory(10)->create();
         Teacher::factory(10)->create();
    }
}
