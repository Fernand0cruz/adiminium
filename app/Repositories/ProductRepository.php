<?php

namespace App\Repositories;

use App\Models\Product;
use App\Repositories\Interfaces\ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface
{
    public function all()
    {
        return Product::paginate(15);
    }

    public function find($id)
    {
        return Product::find($id);
    }

    public function create(array $data)
    {
        return Product::create($data);
    }

    public function update($id, array $data)
    {
        $product = Product::find($id);
        if (!$product) return null;

        $product->update($data);
        return $product;
    }

    public function delete($id)
    {
        $product = Product::find($id);
        if (!$product) return false;

        return $product->delete();
    }
}
