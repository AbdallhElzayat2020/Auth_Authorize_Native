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
            'phone' => ['required', 'max:255', 'phone:AUTO', 'unique:users,phone,' . $id],
            'name' => ['required', 'string', 'max:255'],
            'logout_other_devices' => 'nullable|in:on,off'
        ];
    }

    public function messages(): array
    {
        return [
            'phone.phone' => 'The phone number must be a valid phone number.',
            'phone.unique' => 'The phone number has already been taken.',
        ];
    }
}
