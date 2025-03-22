<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;

class ProductService
{
    public function createProduct(array $data): Product
    {
        $photoPath = $this->handlePhotoUpload($data);

        $data['photo'] = $photoPath;

        return Product::create($data);
    }

    public function getAllProducts(): LengthAwarePaginator
    {
        return Product::paginate(24);
    }

    public function getProductById(int $id): Product
    {
        return Product::findOrFail($id);
    }

    public function updateProduct(int $id, array $data): Product
    {
        $product = Product::findOrFail($id);

        if (isset($data['photo']) && $data['photo'] instanceof UploadedFile) {
            $this->deletePhoto($product);
            $data['photo'] = $this->handlePhotoUpload($data);
        }

        $product->update($data);

        return $product;
    }

    public function deleteProduct(int $id): Product
    {
        $product = Product::findOrFail($id);

        $this->deletePhoto($product);

        $product->delete();

        return $product;
    }

    private function handlePhotoUpload(array &$data): ?string
    {
        if (isset($data['photo']) && $data['photo'] instanceof UploadedFile) {
            return $data['photo']->store('photos', 'public');
        }

        return null;
    }

    private function deletePhoto(Product $product): void
    {
        if ($product->photo) {
            Storage::disk('public')
                ->delete($product->photo);
        }
    }
}
