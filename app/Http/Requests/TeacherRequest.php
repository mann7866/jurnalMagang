<?php
namespace App\Http\Requests;

use App\Enums\GenderEnum;
use App\Models\Teacher;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class TeacherRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        if ($this->isMethod('put') || $this->isMethod('patch')) {

            $teacherId = $this->route('id');
            $teacher   = Teacher::find($teacherId);

            if ($teacher) {
                $this->merge([
                    'user_id' => $teacher->user_id,
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
            'name'                  => ['required', 'string', 'max:255'],
            'no_telp'               => ['required', 'min:11', 'max:12'],
            'email'                 => $this->isMethod('post')
            ? ['required', 'email', 'unique:users,email']
            : ['nullable', 'email', Rule::unique('users', 'email')->ignore($userId)],
            'address'               => ['required', 'string'],
            'nuptk'                 => ['sometimes', 'required', 'string', 'digits:16'],
            'date_of_birth'         => ['required', 'date', 'before:today'],
            'gender'                => ['required', new Enum(GenderEnum::class)],
            'password'              => ['sometimes', 'required', 'min:6', 'confirmed'],
            'password_confirmation' => ['sometimes', 'required', 'same:password'],
        ];
    }

}
