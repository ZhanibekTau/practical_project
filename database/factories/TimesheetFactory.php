<?php

namespace Database\Factories;

use App\Models\Timesheet;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Timesheet>
 */
class TimesheetFactory extends Factory
{
    protected $model = Timesheet::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'task_name' => $this->faker->sentence(),
            'date' => $this->faker->date(),
            'hours' => $this->faker->numberBetween(1, 8),
            'user_id' => \App\Models\User::factory(),
            'project_id' => \App\Models\Project::factory(),
        ];
    }
}
