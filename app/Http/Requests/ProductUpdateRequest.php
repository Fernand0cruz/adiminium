<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator as ValidatorFacade;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Illuminate\Validation\Rule;

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
            'name' => ['required', 'string', 'max:255', Rule::unique('products')->ignore($this->route('product'))],
            'description' => ['required', 'string', 'max:1000'],
            'price' => ['required', 'numeric', 'min:1', 'max:10000'],
            'discount' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'quantity' => ['required', 'integer', 'min:1', 'max:2500'],
        ];
    }
}
