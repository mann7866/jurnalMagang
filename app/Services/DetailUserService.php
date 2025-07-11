<?php
namespace App\Services;

use App\Enums\UploadDiskEnum;
use App\Http\Requests\DetailUserRequest;
use App\Traits\UploadTrait;
use Illuminate\Support\Facades\Hash;

class DetailUserService
{
    use UploadTrait;
    public function prepareData(DetailUserRequest $request, $oldDetail = null)
    {
        $validData = $request->validated();

        $uploadedImage = 'file_not_found';

        if ($request->hasFile('image')) {
            if ($oldDetail != null && $oldDetail->image) {
                $this->remove($oldDetail->image);
            }
            $uploadedImage = $this->upload(
                UploadDiskEnum::IMAGETEACHER->value,
                file: $validData['image']
            );
        }

        $newUser = [
            'name'  => $validData['student_name'],
            'email' => $validData['email'],
        ];

        if (! empty($validData['password'])) {
            $newUser['password'] = Hash::make($validData['password']);
        }

        $newdetail = [
            'no_telp' => $validData['no_telp'],
            'address' => $validData['address'],
        ];

        if ($uploadedImage) {
            $newdetail['image'] = $uploadedImage; // biasanya nama file atau path relatif
        }
        return [
            'user'       => $newUser,
            'detailUser' => $newdetail,
        ];
    }

}
