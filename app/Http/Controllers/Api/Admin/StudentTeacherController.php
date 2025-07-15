<?php
namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StudentTeacherRequest;
use App\Models\StudentTeacher;

class StudentTeacherController extends Controller
{
    public function store(StudentTeacherRequest $request)
    {
        try {
            $data = $request->validated();
            foreach ($data['student_id'] as $studentId) {
                StudentTeacher::create([
                    'teacher_id' => $data['teacher_id'],
                    'student_id' => $studentId,
                ]);
            }

            return response()->json([
                'status'   => true,
                'messages' => 'Store success',
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status'   => false,
                'messages' => 'Failed to add data',
                'data'     => $e->getMessage(),
            ], 422);
        }
    }

}
