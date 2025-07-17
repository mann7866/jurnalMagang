<?php
namespace App\Services;

use App\Contracts\Interfaces\JournalInterface;
use App\Enums\UploadDiskEnum;
use App\Http\Requests\JournalRequest;
use App\Traits\UploadTrait;
use Carbon\Carbon;
use id;
use Illuminate\Support\Facades\Auth;

class JournalService
{
    use UploadTrait;
    private JournalInterface $journalInterface;

    public function __construct(
        JournalInterface $journalInterface,
    ) {
        $this->journalInterface = $journalInterface;
    }

    public function store(JournalRequest $request)
    {
        $validData = $request->validated();
        $studentId = Auth::user()->student?->id;
        $today     = Carbon::today();
        $data      = [
            'student_id' => $studentId,
            'date'       => $today,
        ];
        $alreadyExist = $this->journalInterface->existsJournalToday($data);

        if ($alreadyExist) {
            throw new \Exception('You have made a journal for today.');
        }

        $uploadedImage = 'file_not_found';
        if ($request->hasFile('image')) {
            $uploadedImage = $this->upload(
                UploadDiskEnum::IMAGEJOURNAL->value,
                file: $validData['image']
            );
        }

        $fixDataJournal = [
            'title'       => $validData['title'],
            'description' => $validData['description'],
            'student_id'  => $studentId,
        ];

        if ($uploadedImage) {
            $fixDataJournal['image'] = $uploadedImage;
        }

        return [
            'jurnal' => $fixDataJournal,
        ];

    }
    public function update(JournalRequest $request, $oldData = null)
    {
        $validData = $request->validated();

        // $userId = Auth::id();
        $uploadedImage = $oldData->image ?? null;

        if ($request->hasFile('image')) {
            $newImage = $this->upload(
                disk: UploadDiskEnum::IMAGEJOURNAL->value,
                file: $validData['image']
            );

            if ($oldData != null && $oldData->image) {
                $this->remove($oldData->image);
            }

            $uploadedImage = $newImage;
        }

        $fixDataJournal = [
            'title'       => $validData['title'],
            'description' => $validData['description'],
            // 'user_id' => $userId,
        ];

        if ($uploadedImage) {
            $fixDataJournal['image'] = $uploadedImage;
        }

        return [
            'jurnal' => $fixDataJournal,
        ];

    }

    public function getMissingYesterdayJournals()
    {

        $yesterday = Carbon::yesterday();
        $students  = $this->journalInterface->get();
        $journals  = collect();

        foreach ($students as $student) {
            $data = [
                'student_id' => $student->id,
                'date'       => $yesterday,
            ];
            $alreadyExist = $this->journalInterface->existsJournalToday($data);
            if (!$alreadyExist) {
                $journals->push([
                    'student_id'  => $student->id,
                    'title'       => 'tidak mengisi journal',
                    'description' => 'tidak mengisi journal',
                    'image' => null,
                    'created_at'  => $yesterday,
                    'updated_at'  => $yesterday,
                ]);
            }
        }
        return $journals;
    }

}
