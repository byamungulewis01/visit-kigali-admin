<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        \App\Models\User::create([
            'name' => 'BYAMUNGU Lewis',
            'email' => 'byamungulewis@gmail.com',
            'phone' => '0785436135',
            'role' => 'admin',
            'password' => bcrypt('byamungu')

        ]);
        // \App\Models\User::factory(5)->create();
    }
}
