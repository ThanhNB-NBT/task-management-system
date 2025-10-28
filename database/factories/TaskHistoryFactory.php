<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TaskHistory>
 */
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
            // 'task_id' và 'user_id' sẽ được gán trong Seeder
            'action'    => $this->faker->randomElement(['status_changed', 'assignee_changed', 'priority_changed']),
            'old_value' => $this->faker->word(),
            'new_value' => $this->faker->word(),
        ];
    }
}
