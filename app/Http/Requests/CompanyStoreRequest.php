<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyStoreRequest extends FormRequest
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
        return [
            'photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'cnpj' => 'required|integer|digits:14',
            'business_name' => 'required|string|max:250',
            'phone' => 'required|integer|digits:11',
            'address' => 'string|max:255',
            'street' => 'required|string|min:1|max:250',
            'neighborhood' => 'required|string|min:1|max:250',
            'state' => 'required|string|min:1|max:250',
            'number' => 'required|integer|min:1|max:1000',
            'city' => 'required|string|min:1|max:100',
            'zip_code' => 'required|integer|digits:8'
        ];
    }
    public function messages()
    {
        return [
            'photo.required' => 'The photo field is required.',
        ];

    }
}
