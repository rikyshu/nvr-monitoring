<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Buat User Admin Default untuk Login
        User::factory()->create([
            'name' => 'Admin NVR',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'), // password standar
            'role' => 'admin',
        ]);

        User::factory()->create([
            'name' => 'Viewer',
            'email' => 'viewer@viewer.com',
            'password' => bcrypt('password'), // password standar
            'role' => 'viewer',
        ]);

        // 2. Jalankan NvrEventSeeder agar dashboard ada datanya
        $this->call([
            NvrEventSeeder::class,
        ]);
    }
}
