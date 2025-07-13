<?php

namespace Database\Seeders;

use App\Models\Teacher;
use App\Models\Student;
use App\Models\StudentTeacher;
use Illuminate\Database\Seeder;

class StudentTeacherSeeder extends Seeder
{
    public function run(): void
    {
        StudentTeacher::create([
            'teacher_id' => '1',
            'student_id' => '1'
        ]);
        StudentTeacher::create([
            'teacher_id' => '1',
            'student_id' => '2'
        ]);
        StudentTeacher::create([
            'teacher_id' => '2',
            'student_id' => '3'
        ]);
        StudentTeacher::create([
            'teacher_id' => '3',
            'student_id' => '4'
        ]);
    }
}
