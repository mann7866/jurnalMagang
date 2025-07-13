<?php
namespace App\Http\Resources;

use App\Models\Student;
use App\Models\StudentTeacher;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class AuthResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            'id'              => $this->id,
            'name'            => $this->name,
            'email'           => $this->email,
            'role'            => $this->getRoleNames()->first(),
            'image'           => optional($this->detailUser)->image ? Storage::url($this->image) : null,
            'no_telp'         => optional($this->detailUser)->no_telp,
            'address'         => optional($this->detailUser)->address,
            'date_of_birth'   => optional($this->detailUser)->date_of_birth,
            'nuptk'           => optional($this->detailUser)->nuptk,
            'nisn'            => optional($this->detailUser)->nisn,
            'gender'          => optional($this->detailUser)->gender,
            'student_teacher' => $this->hasRole('teacher')
            ? StudentTeacherResource::collection($this->teacher?->monitoredStudents)
            : [],
        ];

        return array_filter($data, fn($value) => ! is_null($value) && $value !== '');

    }
}
