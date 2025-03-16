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
            'photo' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'business_name' => ['required', 'string', 'max:250', 'unique:companies,business_name'],
            'cnpj' => ['required', 'string', 'size:14', 'unique:companies,cnpj'],
            'phone' => ['required', 'string', 'size:11'],
            'email' => ['required', 'email', 'max:255'],
            'web_site' => ['required', 'url', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'state' => ['required', 'string', 'min:1', 'max:250'],
            'city' => ['required', 'string', 'min:1', 'max:100'],
            'zip_code' => ['required', 'string', 'size:8'],
            'neighborhood' => ['required', 'string', 'min:1', 'max:250'],
            'street' => ['required', 'string', 'min:1', 'max:250'],
            'number' => ['required', 'integer', 'min:1', 'max:1000'],
        ];
    }
}
