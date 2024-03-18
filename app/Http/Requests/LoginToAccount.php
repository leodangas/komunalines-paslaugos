<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginToAccount extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return !auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'password' => ['required'],
            'login' => ['required']
        ];
    }

    /**
     * Get the custom validation messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'password.required' => 'Privaloma užpildyti slaptažodžio lauką',
            'login.required' => 'Privaloma užpildyti prisijungimo vardo lauką',
        ];
    }
}
