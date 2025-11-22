<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title'       => $this->faker->sentence(6),
            'description' => $this->faker->paragraph(2),
            'status'      => $this->faker->randomElement(['pending', 'in_progress', 'done']),
            'priority'    => $this->faker->randomElement(['low', 'medium', 'high']),
            'due_date'    => $this->faker->dateTimeBetween('+1 week', '+3 months'),
        ];
    }
}
