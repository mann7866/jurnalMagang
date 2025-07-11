<?php
namespace App\Services;

use App\Traits\UploadTrait;
use App\Enums\UploadDiskEnum;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\JournalRequest;
use App\Http\Requests\DetailUserRequest;

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
            'date_of_birth' => $validData['date_of_birth'],
            'gender' => $validData['gender'],
        ];

        if(isset($validData['nisn'])){
                $newdetail['nisn'] = $validData['nisn'];
            }

        if(isset($validData['nuptk'])){
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
