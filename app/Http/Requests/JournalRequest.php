<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JournalRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title'       => 'required|min:5|max:50',
            'image'       => $this->isMethod('post') ?
            ['required', 'max:2048'] :
            ['nullable', 'max:2048'],
            'description' => 'required|min:1|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'       => 'Judul wajib diisi.',
            'title.min'            => 'Judul minimal harus terdiri dari 5 karakter.',
            'title.max'            => 'Judul maksimal terdiri dari 50 karakter.',

            'image.required'       => 'Gambar wajib diunggah.',
            'image.max'            => 'Ukuran gambar tidak boleh lebih dari 2MB (2048 KB).',

            'description.required' => 'Deskripsi wajib diisi.',
            'description.min'      => 'Deskripsi minimal harus terdiri dari 150 karakter.',
            'description.max'      => 'Deskripsi maksimal terdiri dari 500 karakter.',
        ];
    }

}
