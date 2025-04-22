<?php

namespace App\Services;

use Illuminate\Foundation\Http\FormRequest;

class FormRequestHandlerService
{
    public function getValidatedData(FormRequest $request): array
    {
        return $request->validated();
    }
}
