<?php

namespace Database\Seeders;

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
        // User::factory(10)->create();
        $this->call([
            RoleSeeder::class,
        ]);

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => 'password',
        ])->assignRole('admin');
        
        User::factory()->create([
            'name' => 'Guru',
            'email' => 'guru@example.com',
            'password' => 'password',
        ])->assignRole('teacher');

        User::factory()->create([
            'name' => 'Siswa',
            'email' => 'siswa@example.com',
            'password' => 'password',
        ])->assignRole('student');

    }
}
