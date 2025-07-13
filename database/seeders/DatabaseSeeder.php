<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Seeders\StudentTeacherSeeder;
use Egulias\EmailValidator\Result\Reason\DetailedReason;

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
            UserSeeder::class,
            DetailUserSeeder::class,
            JournalSeeder::class,
            StudentTeacherSeeder::class
        ]);



    }
}
