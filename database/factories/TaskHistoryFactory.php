<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TaskHistoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'action'    => $this->faker->randomElement(['status_changed', 'assignee_changed', 'priority_changed']),
            'old_value' => $this->faker->word(),
            'new_value' => $this->faker->word(),
        ];
    }
}
