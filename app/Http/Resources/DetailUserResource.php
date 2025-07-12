<?php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\JsonResource;

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
            'image'         => $this->image ? Storage::url($this->image) : null,,
            'student_name'  => optional($this->user)->name,
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

        return array_filter($data, fn($value) => ! is_null($value) && $value !== '');

    }
}
