<?php

namespace App\Services;

use App\Models\Product;

class ProductService
{
    public function getAllProducts()
    {
        // Retorna todos os produtos paginados, com 20 produtos por página.
        return Product::paginate(20);
    }

    public function getProductById($id)
    {
        // Retorna o produto com o ID fornecido.
        return Product::findOrFail($id);
    }

    public function createProduct(array $data)
    {
        // Inicializa a variável $photoPath como nula.
        $photoPath = null;

        // Verifica se o campo 'photo' está presente nos dados e se é uma instância de UploadedFile.
        if (isset($data['photo']) && $data['photo'] instanceof \Illuminate\Http\UploadedFile) {
            // Salva a imagem na pasta 'photos' do disco 'public'.
            $photoPath = $data['photo']->store('photos', 'public');
        }

        // Adiciona o caminho da imagem ao array de dados.
        $data['photo'] = $photoPath;

        // Cria um novo produto com os dados fornecidos.
        return Product::create($data);
    }

    public function updateProduct($id, array $data)
    {
        // Recupera o produto com o ID fornecido.
        $product = Product::findOrFail($id);
        // Atualiza os dados do produto com os novos dados fornecidos.
        $product->fill($data);
        // Salva o produto atualizado no banco de dados.
        $product->save();

        // Retorna o produto atualizado.
        return $product;
    }

    public function deleteProduct($id)
    {
        // Recupera o produto com o ID fornecido.
        $product = Product::findOrFail($id);

        // // Verifica se o produto possui uma foto armazenada.
        if ($product->photo) {
            // Deleta a foto do storage, removendo o arquivo associado.
            \Illuminate\Support\Facades\Storage::disk('public')->delete($product->photo);
        }
        
        // Deleta o produto do banco de dados.
        $product->delete();
    }
}
