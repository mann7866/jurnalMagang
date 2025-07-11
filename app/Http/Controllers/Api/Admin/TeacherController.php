<?php

namespace App\Http\Controllers\Api\Admin;

use App\Contracts\Interfaces\TeacherInterface;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\DetailUserService;
use App\Http\Requests\DetailUserRequest;
use App\Http\Resources\DetailUserResource;

class TeacherController extends Controller
{
     private TeacherInterface $teacherInterface;
    private DetailUserService $detailUserService;

    public function __construct(
        TeacherInterface $teacherInterface,
        DetailUserService $detailUserService,
    ) {
        $this->teacherInterface = $teacherInterface;
        $this->detailUserService   = $detailUserService;
    }
    public function getData()
    {
        try {
            $teacher = $this->teacherInterface->get();
            return response()->json([
                'status'   => true,
                'messages' => 'Collect teacher data',
                'data'     => DetailUserResource::collection($teacher),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status'   => false,
                'messages' => 'error',
                'data'     => $e->getMessage(),
            ], 500);
        }
    }

    public function store(DetailUserRequest $request)
    {
        try {

            $data                       = $this->detailUserService->prepareData($request);
            $newUser                    = User::create($data['user'])->assignRole('teacher');
            $data['detailUser']['user_id'] = $newUser->id;
            $newTeacher                 = $this->teacherInterface->store($data['detailUser']);
            return response()->json([
                'status'   => true,
                'messages' => 'Store success',
                'data'     => new DetailUserResource($newTeacher),
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status'   => false,
                'messages' => 'failed to add data',
                'data'     => $e->getMessage(),
            ], 422);
        }
    }

    public function update(DetailUserRequest $request, $id)
    {
        try {
            $teacher = $this->teacherInterface->find($id);
            if (! $teacher) {
                return response()->json([
                    'status'   => false,
                    'messages' => 'Teacher not found',
                ], 404);
            }
            $data = $this->detailUserService->prepareData($request,$teacher);
            $teacher->user->update([
                'name'  => $data['user']['name'],
                'email' => $data['user']['email'],
            ]);
            $this->teacherInterface->update($id, $data['detailUser']);
            return response()->json([
                'status'   => true,
                'messages' => 'Update success',
                'data'     => $data,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status'   => false,
                'messages' => 'Failed to update data',
                'data'     => $e->getMessage(),
            ], 422);
        }
    }

    public function destroy($id)
    {
        try {
            $teacher = $this->teacherInterface->find($id);
            $userId  = $teacher->user_id;
            User::findOrFail($userId)->delete();
            return response()->json([
                'status'   => true,
                'messages' => 'Success to delete data',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'   => false,
                'messages' => 'Teacher not found',
                'data'     => $e->getMessage(),
            ]);
        }

    }
}
