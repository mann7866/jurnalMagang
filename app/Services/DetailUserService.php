<?php
namespace App\Services;

use App\Http\Requests\DetailUserRequest;
use Illuminate\Support\Facades\Hash;

class DetailUserService
{

    public function prepareData(DetailUserRequest $request)
    {
        $validData = $request->validated();

        $newUser = [
            'name'  => $validData['student_name'],
            'email' => $validData['email'],
        ];

        if (! empty($validData['password'])) {
            $newUser['password'] = Hash::make($validData['password']);
        }

        $newdetail = [
            'no_telp'      => $validData['no_telp'],
            'address'       => $validData['address'],
        ];

        return [
            'user'    => $newUser,
            'detailUser' => $newdetail,
        ];
    }

}
