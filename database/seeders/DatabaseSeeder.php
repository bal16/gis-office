<?php

namespace Database\Seeders;

// use App\Models\District;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@tabel.dev',
            'password' => Hash::make('adminadmin'),
            'accepted_at' => now(),
            'email_verified_at' => now(),
        ]);

        // District::factory(5)->create();
    }
}
