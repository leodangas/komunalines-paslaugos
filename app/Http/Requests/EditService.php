<?php

namespace App\Http\Requests;

use App\Models\Role;
use App\Models\User;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

class EditService extends FormRequest
{  protected $errorBag = 'editServiceForm';

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
            'name' => ['required'],
            'manager_id' => ['nullable', Rule::in(User::where('role_id', Role::MANAGER_ID)->pluck('id'))],
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
            'name.required' => 'Privaloma užpildyti pavadinimo lauką',
            'manager_id.in' => 'Pasirinkta netinkama vadybininko reikšmė',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        // Save the $id parameter in the session
        Session::put('service_id', $this->route('id'));

        parent::failedValidation($validator);
    }


}
