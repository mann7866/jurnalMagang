<?php
namespace App\Http\Requests;

use App\Enums\GenderEnum;
use App\Models\Student;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

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
            'image'                 => $this->isMethod('post')
            ? ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048']
            : ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'name'          => ['required', 'string', 'max:255'],
            'no_telp'               => ['required', 'min:11', 'max:12'],
            'email'                 => $this->isMethod('post')
            ? ['required', 'email', 'unique:users,email']
            : ['nullable', 'email', Rule::unique('users', 'email')->ignore($userId)],
            'address'               => ['required', 'string'],
            'nisn'                  => ['sometimes', 'required', 'string', 'digits:10'],
            'nuptk'                 => ['sometimes', 'required', 'string', 'digits:16'],
            'date_of_birth'         => ['required', 'date', 'before:today'],
            'gender'                => ['required', new Enum(GenderEnum::class)],
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

            'nisn.required'                  => 'NISN wajib diisi.',
            'nisn.string'                    => 'NISN harus berupa teks.',
            'nisn.digits'                    => 'NISN harus terdiri dari 10 digit angka.',

            'nuptk.required'                 => 'NUPTK wajib diisi.',
            'nuptk.string'                   => 'NUPTK harus berupa teks.',
            'nuptk.digits'                   => 'NUPTK harus terdiri dari 16 digit angka.',

            'date_of_birth.required'         => 'Tanggal lahir wajib diisi.',
            'date_of_birth.date'             => 'Tanggal lahir harus berupa format tanggal yang valid.',
            'date_of_birth.before'           => 'Tanggal lahir harus sebelum hari ini.',

            'gender.required'                => 'Gender tidak boleh kosong',
            'gender.enum'                    => 'Gender harus salah satu dari: man atau woman.',

            'password.required'              => 'Password tidak boleh kosong',
            'password.min'                   => 'Password minimal 6 karakter',
            'password.confirmed'             => 'Konfirmasi password tidak cocok',

            'password_confirmation.required' => 'Konfirmasi password wajib diisi',
            'password_confirmation.same'     => 'Konfirmasi password tidak sama dengan password',

            'image.required'                 => 'Gambar wajib diunggah.',
            'image.image'                    => 'File harus berupa gambar.',
            'image.mimes'                    => 'Format gambar harus jpeg, png, jpg, gif, atau svg.',
            'image.max'                      => 'Ukuran gambar maksimal 2MB.',

        ];
    }
}
