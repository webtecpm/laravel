<?php

namespace Database\Seeders;

use App\Models\Employer;
use App\Models\Job;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();

        // User::factory(10)->create([
        //     'first_name' => fake()->firstName(),
        //     'last_name' => fake()->lastName(),
        //     'email' => fake()->email()
        // ]);

        Employer::factory(50)->create();

        Job::factory(50)->create();
    }
}
