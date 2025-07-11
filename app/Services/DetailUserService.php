<?php
namespace App\Services;

use App\Enums\UploadDiskEnum;
use App\Http\Requests\DetailUserRequest;
use App\Traits\UploadTrait;
use Illuminate\Support\Facades\Hash;

class DetailUserService
{
    use UploadTrait;
    public function prepareData(DetailUserRequest $request, $oldData = null)
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
            'name'  => $validData['student_name'],
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

        if (isset($validData['nuptk'])) {
            $newdetail['nuptk'] = $validData['nuptk'];
        }

        if ($uploadedImage) {
            $newdetail['image'] = $uploadedImage; // biasanya nama file atau path relatif
        }
        return [
            'user'       => $newUser,
            'detailUser' => $newdetail,
        ];
    }

}
