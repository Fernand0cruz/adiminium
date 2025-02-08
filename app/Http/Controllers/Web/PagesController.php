<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;

class PagesController extends Controller
{
    public function welcome()
    {
        return Inertia::render('Welcome', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
        ]);
    }

    public function dashboard()
    {
        return Inertia::render('Dashboard');
    }

    public function products()
    {
        return Inertia::render('Product/Products');
    }
    public function listProducts()
    {
        return Inertia::render('Product/ListProducts');
    }

    public function createProduct()
    {
        return Inertia::render('Product/CreateProduct');
    }

    public function product()
    {
        return Inertia::render('Product/Product');
    }

    public function listClients()
    {
        return Inertia::render('Client/ListClient');
    }

    public function createClient()
    {
        return Inertia::render('Client/CreateClient');
    }

    public function client()
    {
        return Inertia::render('Client/Client');
    }


    public function orders()
    {
        return Inertia::render('Order/Orders');
    }

    public function myorders()
    {
        return Inertia::render('Order/MyOrders');
    }
}
