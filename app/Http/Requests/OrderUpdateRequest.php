<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use App\Models\Product;

class OrderUpdateRequest extends FormRequest
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
        $rules = [
            'id' => 'required|exists:orders,id',
            'client_id' => 'required|exists:users,id',
            'products_data' => 'required|array',
            'products_data.*.product_id' => 'required|exists:products,id',
            'products_data.*.price' => 'required|numeric|min:1|max:10000',
            'products_data.*.quantity' => 'required|integer|min:1',
            'status' => 'in:open,in progress,accepted,denied,cancelled',
        ];

        return $rules;
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $status = $this->input('status');
    
            if (in_array($status, ['denied', 'cancelled'])) {
                return;
            }
    
            $productsData = $this->input('products_data', []);
    
            foreach ($productsData as $index => $product) {
                $productId = $product['product_id'];
                $requestedQuantity = $product['quantity'] ?? 0;
    
                $availableStock = Product::find($productId)->stock_quantity ?? 0;
    
                if ($requestedQuantity > $availableStock) {
                    $validator->errors()->add("products_data.$index.quantity", "Quantity exceeds available stock.");
                }
            }
        });
    }
    

    public function messages(): array
    {
        return [
            'products_data.*.quantity.min' => 'Quantity must be at least 1.',
        ];
    }
}
