<?php
namespace App\Services;

use id;
use App\Traits\UploadTrait;
use App\Enums\UploadDiskEnum;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\JournalRequest;
use App\Http\Requests\DetailUserRequest;

class JournalService
{
    use UploadTrait;

     public function store(JournalRequest $request){
        $validData = $request->validated();
        $userId = Auth::id();
        $uploadedImage = 'file_not_found';
        if($request->hasFile('image')) {
            $uploadedImage = $this->upload(
                UploadDiskEnum::IMAGEJOURNAL->value,
                file: $validData['image']
            );
        }

        $fixDataJournal = [
            'title' => $validData['title'],
            'description' => $validData['description'],
            'user_id' => $userId,
        ];

        if ($uploadedImage) {
            $fixDataJournal['image'] = $uploadedImage;
        }

        return[
            'jurnal' => $fixDataJournal
        ];

    }
     public function update(JournalRequest $request, $oldData = null){
        $validData = $request->validated();
        // $userId = Auth::id();
        $uploadedImage = 'file_not_found';
        if($request->hasFile('image')) {
              if ($oldData != null && $oldData->image) {
                $this->remove($oldData->image);
            }

            $uploadedImage = $this->upload(
                UploadDiskEnum::IMAGEJOURNAL->value,
                file: $validData['image']
            );
        }

        $fixDataJournal = [
            'title' => $validData['title'],
            'description' => $validData['description'],
            // 'user_id' => $userId,
        ];

        if ($uploadedImage) {
            $fixDataJournal['image'] = $uploadedImage;
        }

        return[
            'jurnal' => $fixDataJournal
        ];

    }

}
