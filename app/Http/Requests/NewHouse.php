<?php

namespace App\Http\Requests;

use App\Models\Community;
use App\Models\Role;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;


class NewHouse extends FormRequest
{
    protected $errorBag = 'newHouseForm';

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
            'address' => ['required'],
            'community_id' => ['nullable', Rule::in(Community::pluck('id'))]
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
            'address.required' => 'Privaloma užpildyti adreso lauką',
            'community_id.in' => 'Pasirinkta netinkama bendrijos reikšmė',
        ];
    }
}
