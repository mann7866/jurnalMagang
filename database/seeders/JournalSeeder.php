<?php

namespace Database\Seeders;

use App\Models\Journal;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class JournalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 2; $i++) {
            Journal::create([
                'image'       => 'dummy-image-' . $i . '.jpg', // atau pakai Storage::put()
                'title'       => 'Judul Jurnal ' . $i,
                'description' => 'Ini adalah deskripsi jurnal ke-' . $i,
                'student_id'     => 1,
                'created_at'     => Carbon::today(),
            ]);
            Journal::create([
                'image'       => 'dummy-image-' . $i . '.jpg', // atau pakai Storage::put()
                'title'       => 'Judul Jurnal ' . $i,
                'description' => 'Ini adalah deskripsi jurnal ke-' . $i,
                'student_id'     => 2,
                'created_at'     => Carbon::today(),
            ]);
        }
    }
}
