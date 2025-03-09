<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator as ValidatorFacade;
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
            'photo' => [
                'nullable',
                function ($attribute, $value, $fail) {
                   
                    if (is_string($value)) {
    
                    } elseif ($value instanceof UploadedFile) {
  
                        $rules = ['image', 'mimes:jpeg,png,jpg,gif', 'max:2048'];
                        $validator = ValidatorFacade::make(['photo' => $value], ['photo' => $rules]);

                        if ($validator->fails()) {
                            $fail($validator->errors()->first('photo'));
                        }
                    } 
                },
            ],
            'business_name' => 'required|string|max:250',
            'cnpj' => 'required|string|size:14',
            'phone' => 'required|string|size:11',
            'email' => 'required|email|max:255',
            'web_site' => 'required|url|max:255',
            'address' => 'required|string|max:255',
            'state' => 'required|string|min:1|max:250',
            'city' => 'required|string|min:1|max:100',
            'zip_code' => 'required|string|size:8',
            'neighborhood' => 'required|string|min:1|max:250',
            'street' => 'required|string|min:1|max:250',
            'number' => 'required|integer|min:1|max:1000',
        ];
    }

    /**
     * Custom messages for validation rules.
     *
     * @return array<string, string>
     */
    public function messages()
    {
        return [
            'photo.required' => 'The photo field is required.',
            'photo.image' => 'The photo must be an image file.',
            'photo.mimes' => 'The photo must be a jpeg, png, jpg, or gif image.',
            'photo.max' => 'The photo may not be greater than 2 MB.',
        ];
    }
}
