<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\User;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;
use App\Services\DetailUserService;
use App\Http\Controllers\Controller;
use App\Http\Requests\DetailUserRequest;
use App\Http\Resources\DetailUserResource;
use App\Contracts\Interfaces\TeacherInterface;

class TeacherController extends Controller
{
    use UploadTrait;

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

            $data                       = $this->detailUserService->prepareDataTeacher($request);
            $newUser                    = User::create($data['user'])->assignRole('teacher');
            $data['detailTeacher']['user_id'] = $newUser->id;
            $newTeacher                 = $this->teacherInterface->store($data['detailTeacher']);
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
            $data = $this->detailUserService->prepareDataTeacher($request,$teacher);
            $teacher->user->update([
                'name'  => $data['user']['name'],
                'email' => $data['user']['email'],
            ]);
            $this->teacherInterface->update($id, $data['detaiTeacher']);
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
            $oldTeacher = $this->teacherInterface->find($id);
             if ($oldTeacher != null && $oldTeacher->image) {
                $this->remove($oldTeacher->image);
            }
            $userId  = $oldTeacher->user_id;
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
