<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Cashier;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        Cashier::create([
            'name' => 'Chivoan',
            'email' => 'voan@gmail.com',
            'password' => 'voan123',
            'role' => 'Admin',
        ]);
    }
}
