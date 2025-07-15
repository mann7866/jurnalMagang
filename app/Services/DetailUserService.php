<?php
namespace App\Services;

use App\Enums\UploadDiskEnum;
use App\Http\Requests\StudentRequest;
use App\Http\Requests\TeacherRequest;
use App\Traits\UploadTrait;
use Illuminate\Support\Facades\Hash;

class DetailUserService
{
    use UploadTrait;
    public function prepareDataTeacher(TeacherRequest $request, $oldData = null)
    {
        $validData = $request->validated();

        $uploadedImage = $oldData->image ?? null;

        if ($request->hasFile('image')) {
            $newImage = $this->upload(
                disk: UploadDiskEnum::IMAGETEACHER->value,
                file: $validData['image']
            );

            if ($oldData != null && $oldData->image) {
                $this->remove($oldData->image);
            }

            $uploadedImage = $newImage;
        }

        $newUser = [
            'name'  => $validData['name'],
            'email' => $validData['email'],
        ];

        if (! empty($validData['password'])) {
            $newUser['password'] = Hash::make($validData['password']);
        }

        $newdetail = [
            'no_telp'       => $validData['no_telp'],
            'address'       => $validData['address'],
            'date_of_birth' => $validData['date_of_birth'],
            'gender'        => $validData['gender'],
        ];

        if (isset($validData['nuptk'])) {
            $newdetail['nuptk'] = $validData['nuptk'];
        }

        if ($uploadedImage) {
            $newdetail['image'] = $uploadedImage;
        }
        return [
            'user'       => $newUser,
            'detailTeacher' => $newdetail,
        ];
    }
    public function prepareDataStudent(StudentRequest $request, $oldData = null)
    {
        $validData = $request->validated();

        $uploadedImage = $oldData->image ?? null;

        if ($request->hasFile('image')) {
            $newImage = $this->upload(
                disk: UploadDiskEnum::IMAGESTUDENT->value,
                file: $validData['image']
            );

            if ($oldData != null && $oldData->image) {
                $this->remove($oldData->image);
            }

            $uploadedImage = $newImage;
        }

        $newUser = [
            'name'  => $validData['name'],
            'email' => $validData['email'],
        ];

        if (! empty($validData['password'])) {
            $newUser['password'] = Hash::make($validData['password']);
        }

        $newdetail = [
            'no_telp'       => $validData['no_telp'],
            'address'       => $validData['address'],
            'date_of_birth' => $validData['date_of_birth'],
            'gender'        => $validData['gender'],
        ];

        if (isset($validData['nisn'])) {
            $newdetail['nisn'] = $validData['nisn'];
        }

        if ($uploadedImage) {
            $newdetail['image'] = $uploadedImage;
        }
        return [
            'user'       => $newUser,
            'detailStudent' => $newdetail,
        ];
    }

}
