<?php

namespace App\Http\Requests;

use App\Models\Role;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Session;
use Illuminate\Contracts\Validation\Validator;


class EditCommunityService extends FormRequest
{
    protected $errorBag = 'editCommunityServiceForm';

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user() && (auth()->user()->role_id === Role::ADMIN_ID || auth()->user()->role_id === Role::MANAGER_ID);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'price' => ['nullable', 'numeric'],
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
            'price.numeric' => 'Kaina turi būti skaičius',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        // Save the $id parameter in the session
        Session::put('community_service_id', $this->route('id'));

        parent::failedValidation($validator);
    }
}
