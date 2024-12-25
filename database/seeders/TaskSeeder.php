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
            'title' => 'Sample Task 1',
            'description' => 'This is a description for task 1.',
            'status' => 'pending',
            'due_date' => '2024-12-31',
        ]);

        Task::create([
            'title' => 'Sample Task 2',
            'description' => 'This is a description for task 2.',
            'status' => 'in-progress',
            'due_date' => '2025-01-15',
        ]);

        Task::create([
            'title' => 'Sample Task 3',
            'description' => 'This is a description for task 3.',
            'status' => 'completed',
            'due_date' => '2024-12-25',
        ]);
    }
}
