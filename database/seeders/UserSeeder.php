<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name'     => 'Admin',
            'email'    => 'admin@example.com',
            'password' => 'password',
        ])->assignRole('admin');


        // guru
        User::factory()->create([
            'name'     => 'Guru',
            'email'    => 'guru@example.com',
            'password' => 'password',
        ])->assignRole('teacher');
        User::factory()->create([
            'name'     => 'Guru2',
            'email'    => 'guru2@example.com',
            'password' => 'password',
        ])->assignRole('teacher');
        User::factory()->create([
            'name'     => 'Guru3',
            'email'    => 'guru3@example.com',
            'password' => 'password',
        ])->assignRole('teacher');
        User::factory()->create([
            'name'     => 'Guru4',
            'email'    => 'guru4@example.com',
            'password' => 'password',
        ])->assignRole('teacher');



        // student
        User::factory()->create([
            'name'     => 'Siswa',
            'email'    => 'siswa@example.com',
            'password' => 'password',
        ])->assignRole('student');
        User::factory()->create([
            'name'     => 'Siswa2',
            'email'    => 'siswa2@example.com',
            'password' => 'password',
        ])->assignRole('student');
        User::factory()->create([
            'name'     => 'Siswa3',
            'email'    => 'siswa3@example.com',
            'password' => 'password',
        ])->assignRole('student');
        User::factory()->create([
            'name'     => 'Siswa4',
            'email'    => 'siswa4@example.com',
            'password' => 'password',
        ])->assignRole('student');
    }
}
