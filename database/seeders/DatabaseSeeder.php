<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Only create users if they don't exist
        if (!User::where('username', 'admin')->exists()) {
            User::factory()->create([
                'name' => 'Admin User',
                'username' => 'admin',
                'email' => 'admin@test.com',
                'password' => bcrypt('password'),
                'role' => 'admin',
            ]);
        }

        if (!User::where('username', 'testuser')->exists()) {
            User::factory()->create([
                'name' => 'Test User',
                'username' => 'testuser',
                'email' => 'testuser@example.com',
                'password' => bcrypt('password'),
                'role' => 'user',
            ]);
        }

        // Call other seeders
        $this->call([
            ResidentSeeder::class,
            AppointmentSeeder::class,
            BlotterSeeder::class,
            AssetSeeder::class,
        ]);
    }
}
