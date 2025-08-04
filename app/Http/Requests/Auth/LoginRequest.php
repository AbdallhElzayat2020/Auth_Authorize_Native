<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'identifier' => ['required', 'max:100'],
            'password' => ['required', 'min:8', 'string', 'max:255'],
            'remember' => ['nullable', 'in:on,off'],
            // 'g-recaptcha-response' => 'required|captcha'
        ];
    }
}