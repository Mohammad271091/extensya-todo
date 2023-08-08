<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 15; $i++) {
            $task = [
                'task' => fake()->sentence(3),
                'description' => fake()->words(5, true),
                'created_at' => fake()->dateTimeBetween('-1 month', 'now'),
            ];

            // Insert the fake task into the 'tasks' table
            DB::table('tasks')->insert($task);
        }
    }
}
