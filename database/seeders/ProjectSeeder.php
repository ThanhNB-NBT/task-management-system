<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Project;
use App\Models\User;

class ProjectSeeder extends Seeder
{

    public function run(): void
    {
        $leaderIds = User::where('role', 'leader')->pluck('id');

        Project::factory(10)
            ->sequence(fn () => [
                'leader_id' => $leaderIds->random()
            ])
            ->create();
    }
}
