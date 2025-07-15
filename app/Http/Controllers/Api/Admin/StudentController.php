<?php
namespace App\Http\Controllers\Api\Admin;

use App\Contracts\Interfaces\StudentInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\StudentRequest;
use App\Http\Resources\DetailUserResource;
use App\Models\User;
use App\Services\DetailUserService;
use App\Traits\UploadTrait;

class StudentController extends Controller
{
    use UploadTrait;

    private StudentInterface $studentInterface;
    private DetailUserService $detailUserService;

    public function __construct(
        StudentInterface $studentInterface,
        DetailUserService $detailUserService,
    ) {
        $this->studentInterface  = $studentInterface;
        $this->detailUserService = $detailUserService;
    }

    public function store(StudentRequest $request)
    {
        try {

            $data                             = $this->detailUserService->prepareDataStudent($request);
            $newUser                          = User::create($data['user'])->assignRole('student');
            $data['detailStudent']['user_id'] = $newUser->id;
            $newStudent                       = $this->studentInterface->store($data['detailStudent']);
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

    public function update(StudentRequest $request, $id)
    {
        try {
            $student = $this->studentInterface->find($id);
            if (! $student) {
                return response()->json([
                    'status'   => false,
                    'messages' => 'Student not found',
                ], 404);
            }
            $data = $this->detailUserService->prepareDataStudent($request, $student);
            $student->user->update([
                'name'  => $data['user']['name'],
                'email' => $data['user']['email'],
            ]);
            $this->studentInterface->update($id, $data['detailStudent']);
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
            $oldStudent = $this->studentInterface->find($id);
            if ($oldStudent != null && $oldStudent->image) {
                $this->remove($oldStudent->image);
            }
            $userId = $oldStudent->user_id;
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
