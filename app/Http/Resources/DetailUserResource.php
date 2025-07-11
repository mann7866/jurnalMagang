<?php
namespace App\Http\Resources;

use Illuminate\Http\Request;
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
        return [
            'image'      => $this->image,
            'student_name' => optional($this->user)->name,
            'no_telp'      => $this->no_telp,
            'address'       => $this->address,
            'user_id'      => $this->user_id,
            'user_email'   => optional($this->user)->email,
            'role'         => optional($this->user)->getRoleNames()->first(),
        ];
    }
}
