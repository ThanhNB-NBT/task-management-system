<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Notification>
 */
class NotificationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // 'user_id' sẽ được gán trong Seeder
            'message' => $this->faker->sentence(10),
            'is_read' => $this->faker->boolean(20), // 20% là "true" (đã đọc)
        ];
    }
}
