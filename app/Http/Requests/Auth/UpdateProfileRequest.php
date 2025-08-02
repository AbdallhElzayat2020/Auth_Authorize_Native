<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
        $id = auth()->user()->id;

        return [
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $id],
            'phone' => ['required', 'max:255', 'regex:/^01[0125][0-9]{8}$/', 'unique:users,phone,' . $id],
            'name' => ['required', 'string', 'max:255'],
        ];
    }
}
