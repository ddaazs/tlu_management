<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email,' . $this->user()->id,
                'regex:/^[a-zA-Z0-9._%+-]+@tlu\.edu\.vn$/',
            ],
            'password' => 'nullable|min:6',
            'role' => 'required|in:quantri,giangvien,sinhvien',
        ];
    }

    public function messages(): array
    {
        return [
            'email.regex' => 'Email phải chứa @tlu.edu.vn'
        ];
    }
}
