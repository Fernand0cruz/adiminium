<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator as ValidatorFacade;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class CompanyUpdateRequest extends FormRequest
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
            'image' => [
                'nullable',
                function ($attribute, $value, $fail) {
                    if (is_string($value) && filter_var($value, FILTER_VALIDATE_URL)) {
                        if (!URL::isValidUrl($value)) {
                            $fail('The image URL is invalid.');
                        }
                    }
                    elseif ($value instanceof UploadedFile) {
                        $rules = ['image', 'mimes:jpeg,png,jpg,gif', 'max:2048'];
                        $validator = ValidatorFacade::make(['image' => $value], ['image' => $rules]);

                        if ($validator->fails()) {
                            $fail($validator->errors()->first('image'));
                        }
                    }
                },
            ],
            'business_name' => ['required', 'string', 'max:250', Rule::unique('companies')->ignore($this->route('company'))],
            'cnpj' => ['required', 'string', 'size:14', Rule::unique('companies')->ignore($this->route('company'))],
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
