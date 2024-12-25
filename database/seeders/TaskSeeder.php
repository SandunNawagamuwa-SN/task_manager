<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Task;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Task::create([
            'title' => 'Java',
            'description' => 'Learn.',
            'status' => 'pending',
            'due_date' => '2024-12-31',
        ]);

        Task::create([
            'title' => 'PHP',
            'description' => 'Project',
            'status' => 'in-progress',
            'due_date' => '2025-01-15',
        ]);

        Task::create([
            'title' => 'Rust',
            'description' => 'Learn',
            'status' => 'completed',
            'due_date' => '2024-12-25',
        ]);

        Task::create([
            'title' => 'React',
            'description' => 'Project',
            'status' => 'completed',
            'due_date' => '2024-12-28',
        ]);

        Task::create([
            'title' => 'YypeScript',
            'description' => 'Learn',
            'status' => 'pending',
            'due_date' => '2024-12-28',
        ]);

        Task::create([
            'title' => 'Kotlin',
            'description' => 'Learn',
            'status' => 'in-progress',
            'due_date' => '2024-12-30',
        ]);

        Task::create([
            'title' => 'Flutter',
            'description' => 'Research',
            'status' => 'completed',
            'due_date' => '2024-12-30',
        ]);
    }
}
