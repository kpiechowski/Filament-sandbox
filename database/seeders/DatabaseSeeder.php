<?php

namespace Database\Seeders;

use App\Models\Equipment;
use App\Models\Task;
use App\Models\User;
use App\Models\Workshop;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = User::factory(4)->create([
            'status' => 'User'
        ]);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => '123',
            'status' => 'Admin'
        ]);

        Task::factory(15)->recycle($users)->create();

        Workshop::factory(5)->create();

        Equipment::factory(35)->create();



    }
}
