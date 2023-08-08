<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create the first user
        DB::table('users')->insert([
            'name' => 'Mohammad',
            'email' => 'mohammad@gmail.com',
            'password' => Hash::make('password1234'),
            'is_admin' => 1
        ]);

        // Create the second user
        DB::table('users')->insert([
            'name' => 'Sara',
            'email' => 'sara@gmail.com',
            'password' => Hash::make('password1234'),
        ]);

        // make another 10 fake users 
        for ($i = 0; $i < 10; $i++) {
            DB::table('users')->insert([
                'name' => fake()->name(),
                'email' => fake()->unique()->safeEmail,
                'password' => Hash::make('password1234'),
            ]);
        }
    }
}
