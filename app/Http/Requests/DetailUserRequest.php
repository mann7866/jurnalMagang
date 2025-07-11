<?php
namespace App\Http\Requests;

use App\Models\Student;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DetailUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        if ($this->isMethod('put') || $this->isMethod('patch')) {
            $studentId = $this->route('id');
            $student   = Student::find($studentId);

            if ($student) {
                $this->merge([
                    'user_id' => $student->user_id,
                ]);
            }
        }
    }

    public function rules(): array
    {
        $userId = $this->input('user_id');

        return [
            'image'                 => $this->isMethod('post') ?
            ['required', 'max:2048'] :
            ['nullable', 'max:2048'],
            'student_name'          => ['required', 'string', 'max:255'],
            'no_telp'               => ['required', 'min:11', 'max:12'],
            'email'                 => $this->isMethod('post')
            ? ['required', 'email', 'unique:users,email']
            : ['required', 'email', Rule::unique('users', 'email')->ignore($userId)],
            'address'               => ['required', 'string'],
            'nisn'                  => ['sometimes', 'required', 'string'],
            'nuptk'                 => ['sometimes', 'required', 'string'],
            'date_of_birth'          => ['required'],
            'gender'                 => ['required'],
            'password'              => ['sometimes', 'required', 'min:6', 'confirmed'],
            'password_confirmation' => ['sometimes', 'required', 'same:password'],
        ];
    }

    public function messages(): array
    {
        return [
            'student_name.required'          => 'Nama siswa tidak boleh kosong',
            'student_name.string'            => 'Nama siswa harus berupa teks',
            'student_name.max'               => 'Nama siswa maksimal 255 karakter',

            'email.required'                 => 'Email tidak boleh kosong',
            'email.email'                    => 'Format email tidak valid',
            'email.unique'                   => 'Email sudah digunakan',

            'address.required'               => 'Alamat tidak boleh kosong',
            'address.string'                 => 'Alamat harus berupa teks',

            'nisn.required'                  => 'Nisn tidak boleh kosong',
            'nisn.string'                    => 'Nisn harus berupa teks',

            'nuptk.required'                 => 'Nuptk tidak boleh kosong',
            'nuptk.string'                   => 'Nuptk harus berupa teks',

            'date_of_birth.required'                 => 'Tanggal lahir tidak boleh kosong',

            'gender.required'                 => 'Gender tidak boleh kosong',

            'password.required'              => 'Password tidak boleh kosong',
            'password.min'                   => 'Password minimal 6 karakter',
            'password.confirmed'             => 'Konfirmasi password tidak cocok',

            'password_confirmation.required' => 'Konfirmasi password wajib diisi',
            'password_confirmation.same'     => 'Konfirmasi password tidak sama dengan password',

            'image.required'                 => 'Foto wajib diunggah.',
            'image.max'                      => 'Ukuran foto maksimal 2MB.',
        ];
    }
}
