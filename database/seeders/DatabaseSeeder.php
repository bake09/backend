<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Task;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        Task::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'TestUser1',
            'email' => 'test@test.com',
            'firstname' => 'Basar',
            'lastname' => 'Ökke',
            'birthday' => '06.08.1984',
            'password' => bcrypt('password'),
            'email_verified_at' => NULL,
        ]);
        \App\Models\User::factory()->create([
            'name' => 'TestUser2',
            'email' => 'test2@test.com',
            'firstname' => 'Kader',
            'lastname' => 'Ökke',
            'birthday' => '28.04.1984',
            'password' => bcrypt('password'),
            'email_verified_at' => NULL,
        ]);
    }
}
