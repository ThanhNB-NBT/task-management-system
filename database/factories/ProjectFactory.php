<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'        => $this->faker->company(),
            'description' => $this->faker->paragraph(3),
            'start_date'  => $this->faker->dateTimeBetween('-1 month', '+1 month'),
            'end_date'    => $this->faker->dateTimeBetween('+2 months', '+6 months'),
        ];
    }
}
