<?php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class JournalResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name'         => $this->student?->user?->name ?? 'Nama tidak tersedia',
            'id'           => $this->id,
            'image'        => $this->image ? Storage::url($this->image) : null,
            'title'        => $this->title,
            'description'  => $this->description,
            'created_date' => Carbon::parse($this->created_at)->format('Y-m-d'),
            'created_time' => Carbon::parse($this->created_at)->format('H:i:s'),
        ];
    }
}
