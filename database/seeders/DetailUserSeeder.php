<?php
namespace Database\Seeders;

use App\Models\Student;
use App\Models\Teacher;
use App\Enums\GenderEnum;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class DetailUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // teacher detail
        Teacher::create([
            'image'         => 'images/default.png',
            'no_telp'       => '08' . rand(111111111, 999999999),
            'address'       => 'Jl. Contoh Alamat No. ' . rand(1, 100),
            'date_of_birth' => now()->subYears(rand(18, 30))->subDays(rand(0, 365)),
            'nuptk'          => implode('', array_map(fn() => mt_rand(0, 9), range(1, 16))),
            'gender'        => collect(GenderEnum::cases())->random()->value,
            'user_id'       => 2,
        ]);
        Teacher::create([
            'image'         => 'images/default.png',
            'no_telp'       => '08' . rand(111111111, 999999999),
            'address'       => 'Jl. Contoh Alamat No. ' . rand(1, 100),
            'date_of_birth' => now()->subYears(rand(18, 30))->subDays(rand(0, 365)),
            'nuptk'          => implode('', array_map(fn() => mt_rand(0, 9), range(1, 16))),
            'gender'        => collect(GenderEnum::cases())->random()->value,
            'user_id'       => 3,
        ]);
        Teacher::create([
            'image'         => 'images/default.png',
            'no_telp'       => '08' . rand(111111111, 999999999),
            'address'       => 'Jl. Contoh Alamat No. ' . rand(1, 100),
            'date_of_birth' => now()->subYears(rand(18, 30))->subDays(rand(0, 365)),
            'nuptk'          => implode('', array_map(fn() => mt_rand(0, 9), range(1, 16))),
            'gender'        => collect(GenderEnum::cases())->random()->value,
            'user_id'       => 4,
        ]);
        Teacher::create([
            'image'         => 'images/default.png',
            'no_telp'       => '08' . rand(111111111, 999999999),
            'address'       => 'Jl. Contoh Alamat No. ' . rand(1, 100),
            'date_of_birth' => now()->subYears(rand(18, 30))->subDays(rand(0, 365)),
            'nuptk'          => implode('', array_map(fn() => mt_rand(0, 9), range(1, 16))),
            'gender'        => collect(GenderEnum::cases())->random()->value,
            'user_id'       => 5,
        ]);

        // user detail
        Student::create([
            'image'         => 'images/default.png',
            'no_telp'       => '08' . rand(111111111, 999999999),
            'address'       => 'Jl. Contoh Alamat No. ' . rand(1, 100),
            'date_of_birth' => now()->subYears(rand(18, 30))->subDays(rand(0, 365)),
            'nisn'          => implode('', array_map(fn() => mt_rand(0, 9), range(1, 10))),
            'gender'        => collect(GenderEnum::cases())->random()->value,
            'user_id'       => 6,
        ]);
        Student::create([
            'image'         => 'images/default.png',
            'no_telp'       => '08' . rand(111111111, 999999999),
            'address'       => 'Jl. Contoh Alamat No. ' . rand(1, 100),
            'date_of_birth' => now()->subYears(rand(18, 30))->subDays(rand(0, 365)),
            'nisn'          => implode('', array_map(fn() => mt_rand(0, 9), range(1, 10))),
            'gender'        => collect(GenderEnum::cases())->random()->value,
            'user_id'       => 7,
        ]);
        Student::create([
            'image'         => 'images/default.png',
            'no_telp'       => '08' . rand(111111111, 999999999),
            'address'       => 'Jl. Contoh Alamat No. ' . rand(1, 100),
            'date_of_birth' => now()->subYears(rand(18, 30))->subDays(rand(0, 365)),
            'nisn'          => implode('', array_map(fn() => mt_rand(0, 9), range(1, 10))),
            'gender'        => collect(GenderEnum::cases())->random()->value,
            'user_id'       => 8,
        ]);
        Student::create([
            'image'         => 'images/default.png',
            'no_telp'       => '08' . rand(111111111, 999999999),
            'address'       => 'Jl. Contoh Alamat No. ' . rand(1, 100),
            'date_of_birth' => now()->subYears(rand(18, 30))->subDays(rand(0, 365)),
            'nisn'          => implode('', array_map(fn() => mt_rand(0, 9), range(1, 10))),
            'gender'        => collect(GenderEnum::cases())->random()->value,
            'user_id'       => 9,
        ]);
    }
}
