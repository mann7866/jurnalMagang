<?php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class DetailUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            'id'            => $this->id,
            'image'         => $this->image ? Storage::url($this->image) : null,
            'name'          => optional($this->user)->name,
            'no_telp'       => $this->no_telp,
            'address'       => $this->address,
            'user_id'       => $this->user_id,
            'date_of_birth' => $this->date_of_birth,
            'gender'        => $this->gender,
            'nisn'          => $this->nisn,
            'nuptk'         => $this->nuptk,
            'user_email'    => optional($this->user)->email,
            'role'          => optional($this->user)->getRoleNames()->first(),
        ];

        if ($this->monitoredStudents && $this->monitoredStudents->isNotEmpty()) {
            $data['student_teacher'] = $this->monitoredStudents
                ->map(fn($teacher) => optional($teacher->user)->name)
                ->filter()
                ->values();
        }

        if ($this->monitoringTeachers && $this->monitoringTeachers->isNotEmpty()) {
            $data['teacher_student'] = $this->monitoringTeachers
                ->map(fn($teacher) => optional($teacher->user)->name)
                ->filter()
                ->values();
        }

        return array_filter($data, fn($value) => ! is_null($value) && $value !== '');

    }
}
