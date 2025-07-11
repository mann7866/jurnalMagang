<?php
namespace App\Http\Controllers\Api\Admin;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\DetailUserRequest;
use App\Contracts\Interfaces\StudentInterface;
use App\Http\Resources\DetailUserResource;
use App\Services\DetailUserService;

class StudentController extends Controller
{
    private StudentInterface $studentInterface;
    private DetailUserService $detailUserService;

    public function __construct(
        StudentInterface $studentInterface,
        DetailUserService $detailUserService,
    ) {
        $this->studentInterface = $studentInterface;
        $this->detailUserService   = $detailUserService;
    }
    public function getData()
    {
        try {
            $student = $this->studentInterface->get();
            return response()->json([
                'status'   => true,
                'messages' => 'Collect student data',
                'data'     => DetailUserResource::collection($student),
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
            $newUser                    = User::create($data['user'])->assignRole('student');
            $data['detailUser']['user_id'] = $newUser->id;
            $newStudent                 = $this->studentInterface->store($data['detailUser']);
            return response()->json([
                'status'   => true,
                'messages' => 'Store success',
                'data'     => new DetailUserResource($newStudent),
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status'   => false,
                'messages' => 'failed to store data',
                'data'     => $e->getMessage(),
            ], 422);
        }
    }

    public function update(DetailUserRequest $request, $id)
    {
        try {
            $student = $this->studentInterface->find($id);
            if (! $student) {
                return response()->json([
                    'status'   => false,
                    'messages' => 'Student not found',
                ], 404);
            }
            $data = $this->detailUserService->prepareData($request, $student);
            $student->user->update([
                'name'  => $data['user']['name'],
                'email' => $data['user']['email'],
            ]);
            $this->studentInterface->update($id, $data['detailUser']);
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
            $student = $this->studentInterface->find($id);
            $userId  = $student->user_id;
            User::findOrFail($userId)->delete();
            return response()->json([
                'status'   => true,
                'messages' => 'Success to delete data',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'   => false,
                'messages' => 'Student not found',
            ]);
        }

    }
}
