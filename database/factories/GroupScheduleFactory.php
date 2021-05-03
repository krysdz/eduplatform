<?php

namespace Database\Factories;

use App\Enums\DayOfWeekType;
use App\Models\Group;
use App\Models\GroupSchedule;
use Illuminate\Database\Eloquent\Factories\Factory;

class GroupScheduleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = GroupSchedule::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $hour = $this->faker->numberBetween(8,18);
        return [
            'group_id' => Group::factory(),
            'day_of_week_type' => DayOfWeekType::getRandomInstance(),
            'interval_days' => $this->faker->numberBetween(1,4),
            'start_time' => $hour.':00:00',
            'end_time' => $hour + $this->faker->numberBetween(1,4).':00:00',
            'room_name' => $this->faker->bothify('?-##-##'),
        ];
    }
}
