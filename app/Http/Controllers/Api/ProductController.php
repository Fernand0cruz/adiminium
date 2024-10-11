<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::get();

        return response()->json([
            'products' => $products,
        ], 200);
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);

        return response()->json([
            'product' => $product,
        ], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'price' => 'required|numeric|min:1',
            'stock_quantity' => 'required|integer|min:1',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos', 'public');
        }

        Product::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'stock_quantity' => $validated['stock_quantity'],
            'photo' => $photoPath,
        ]);

        return response()->json(['success' => 'Produto registrado com sucesso!'], 200);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'price' => 'required|numeric|min:1',
            'stock_quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($id);

        $product->fill($validated);
        $product->save();

        return response()->json(['success' => 'Produto atualizado com sucesso!'], 200);
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return response()->json(['success' => 'Produto excluído com sucesso.'], 200);
    }
}
