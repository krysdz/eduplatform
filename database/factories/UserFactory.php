<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $firstName = $this->faker->firstName;
        $lastName = $this->faker->lastName;
        $email = strtolower($firstName . '.' . $lastName . '@example.com');
        $password = 'qwerty';

        return [
            'email' => $email,
            'email_verified_at' => now(),
            'password' => Hash::make($password),

            'first_name' => $firstName,
            'last_name' => $lastName,
            'phone' => $this->faker->phoneNumber,

            'code' => $this->faker->numerify('#######'),
            'website' => $this->faker->domainName,
            'degree' => $this->faker->randomElement(['dr', 'mgr', 'prof.', 'mgr inż.']),

            'remember_token' => Str::random(10),
        ];
    }
}
