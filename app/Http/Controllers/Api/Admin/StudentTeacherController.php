<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StudentTeacherRequest;
use App\Models\StudentTeacher;
use Illuminate\Http\Request;

class StudentTeacherController extends Controller
{
    public function store(StudentTeacherRequest $request){
        try{
            StudentTeacher::created($request->validated());
             return response()->json([
                'status'   => true,
                'messages' => 'Store success',
            ], 201);
        }catch(\Exception $e){
             return response()->json([
                'status'   => false,
                'messages' => 'failed to add data',
                'data'     => $e->getMessage(),
            ], 422);
        }
    }
}
