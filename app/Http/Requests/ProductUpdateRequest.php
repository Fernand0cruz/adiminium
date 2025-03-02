<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator as ValidatorFacade;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ProductUpdateRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'price' => 'required|numeric|min:1|max:10000',
            'discount' => 'nullable|numeric|min:0|max:100',
            'quantity' => 'required|integer|min:1|max:2500',
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
            'price.min' => 'The price must be at least R$ 1.00.',
            'price.max' => 'The price cannot be greater than R$ 10,000.00.',
        ];
    }
}
