<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'unique:users,phone', 'phone:AUTO'],
            'role' => ['required', 'string', 'in:teacher,student'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => ['required', 'string', 'min:6'],
        ];
    }

    public function messages()
    {
        return [
            'phone.phone' => 'The phone number must be a valid phone number.',
            'phone.unique' => 'The phone number has already been taken.',
        ];
    }
}
