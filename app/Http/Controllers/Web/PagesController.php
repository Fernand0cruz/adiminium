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
        return Inertia::render('Products/Index');
    }

    public function listProducts()
    {
        return Inertia::render('Products/List');
    }

    public function createProduct()
    {
        return Inertia::render('Products/Create');
    }

    public function product()
    {
        return Inertia::render('Products/Show');
    }

    public function editProduct()
    {
        return Inertia::render('Products/Edit');
    }

    public function listCompanies()
    {
        return Inertia::render('Companies/Index');
    }

    public function createCompanies()
    {
        return Inertia::render('Companies/Create');
    }

    public function company()
    {
        return Inertia::render('Companies/Show');
    }

    public function editCompanies()
    {
        return Inertia::render('Companies/Edit');
    }

    public function listClients()
    {
        return Inertia::render('Clients/List');
    }

    public function createClient()
    {
        return Inertia::render('Clients/Create');
    }

    public function client()
    {
        return Inertia::render('Clients/Show');
    }

    public function orders()
    {
        return Inertia::render('Orders/Index');
    }

    public function myOrders()
    {
        return Inertia::render('Orders/MyOrders');
    }
}
