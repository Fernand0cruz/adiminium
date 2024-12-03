<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

class OrderStoreRequest extends FormRequest
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

        $product = Product::find($this->product_id);

        $availableStock = $product ? $product->stock_quantity : 0;

        $products = $this->products; 

        $rules = [
            'client_id' => 'required|exists:users,id',
            'products_data' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id', 
            'products.*.price' => 'required|numeric|min:1|max:10000',
            'products.*.quantity' => 'required|integer|min:1', 
        ];

        if ($products) {
            foreach ($products as $index => $product) {
                $availableStock = Product::find($product['product_id'])->stock_quantity ?? 0;
               
                $rules["products.$index.quantity"] .= "|max:$availableStock";
            }
        }

        return $rules;
    }
}
