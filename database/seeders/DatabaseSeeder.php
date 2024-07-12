<?php

namespace Database\Seeders;

use App\Models\Equipment;
use App\Models\Group;
use App\Models\Task;
use App\Models\User;
use App\Models\Worker;
use App\Models\Workshop;
use App\UserStatus;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        
        User::factory()->create([
            'name' => 'Admin user',
            'email' => 'test@example.com',
            'password' => '123',
            'status' => UserStatus::ADMIN,
        ]);

        User::factory()->create([
            'name' => 'Just user',
            'email' => 'user@example.com',
            'password' => '123',
            'status' => UserStatus::USER,
        ]);
        
        $worker_user = User::factory()->create([
            'name' => 'Worker',
            'email' => 'w@example.com',
            'password' => '123',
            'status' => UserStatus::WORKER,
        ]);

        Worker::factory(1)->recycle($worker_user)->create();

        $workers = Worker::factory(5)->create();

        Task::factory(5)->recycle($workers)->create();

        Workshop::factory(5)->create();

        Equipment::factory(35)->create();

        Group::factory()->gold()->create();
        Group::factory()->silver()->create();


    }
}
