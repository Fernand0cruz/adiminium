<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductService
{
    public function getAllProducts(): LengthAwarePaginator
    {
        return Product::select('id', 'name', 'description', 'price', 'discount', 'quantity')
            ->paginate(25);
    }

    public function getProductById($id)
    {
        return Product::findOrFail($id);
    }

    public function createProduct(array $data)
    {
        $photoPath = null;

        if (isset($data['photo']) && $data['photo'] instanceof \Illuminate\Http\UploadedFile) {
            $photoPath = $data['photo']->store('photos', 'public');
        }

        $data['photo'] = $photoPath;

        return Product::create($data);
    }

    public function updateProduct($id, array $data)
    {
        $product = Product::findOrFail($id);
        $product->fill($data);
        $product->save();

        return $product;
    }

    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);

        if ($product->photo) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($product->photo);
        }

        $product->delete();
    }
}
