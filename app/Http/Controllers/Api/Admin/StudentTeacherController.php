<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StudentTeacherRequest;
use App\Models\StudentTeacher;
use App\Models\Teacher;
use Illuminate\Http\Request;

class StudentTeacherController extends Controller
{
    public function store(StudentTeacherRequest $request)
    {
        try {
            $validatedData = $request->validated();

            $teacher = Teacher::findOrFail($validatedData['teacher_id']);

            $teacher->monitoredStudents()->sync($validatedData['student_ids'] ?? []);

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
