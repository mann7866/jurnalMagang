<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentTeacherResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
         $data = [
            'name'  => optional($this->user)->name,
        ];

        return array_filter($data, fn($value) => ! is_null($value) && $value !== '');
    }
}
