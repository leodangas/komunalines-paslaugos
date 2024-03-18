<?php

namespace App\Http\Requests;

use App\Models\Role;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

class EditUser extends FormRequest
{
    protected $errorBag = 'editUserForm';

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user() && auth()->user()->role_id === Role::ADMIN_ID;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'role_id' => ['required', Rule::in([Role::ADMIN_ID, Role::MANAGER_ID, Role::DEFAULT_ID])],
            'name' => ['required'],
            'last_name' => ['required'],
            'house_id' => ['nullable'],
            'phone' => ['required']
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
            'community_id.in' => 'Pasirinkta netinkama bendrijos reikšmė',
            'role_id.required' => 'Privaloma užpildyti rolės lauką',
            'role_id.in' => 'Pasirinkta negaliojanti rolės reikšmė',
            'last_name.required' => 'Privaloma užpildyti pavardės lauką',
            'name.required' => 'Privaloma užpildyti vardo lauką',
            'phone.required' => 'Privaloma užpildyti telefono lauką'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        // Save the $id parameter in the session
        Session::put('user_id', $this->route('id'));

        parent::failedValidation($validator);
    }
}
