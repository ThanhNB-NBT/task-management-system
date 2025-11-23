<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Notification;

class NotificationSeeder extends Seeder
{

    public function run(): void
    {
        $userIds = User::pluck('id');

        Notification::factory(50)
            ->sequence(fn () => [
                'user_id' => $userIds->random()
            ])
            ->create();
    }
}
