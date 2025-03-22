<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Inertia\Response;

class PagesController extends Controller
{
    public function welcome(): Response
    {
        return Inertia::render('Welcome', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
        ]);
    }

    public function dashboard(): Response
    {
        return Inertia::render('Dashboard');
    }

    public function catalogProducts(): Response
    {
        return Inertia::render('Products/Catalog');
    }
    //public function catalogProduct(): Response
    //{
        //return Inertia::render('Products/Show');
        //}

    public function listProducts(): Response
    {
        return Inertia::render('Products/Index');
    }

    public function createProduct(): Response
    {
        return Inertia::render('Products/Create');
    }

    public function product(): Response
    {
        return Inertia::render('Products/Show');
    }

    public function editProduct(): Response
    {
        return Inertia::render('Products/Edit');
    }

    public function listCompanies(): Response
    {
        return Inertia::render('Companies/Index');
    }

    public function createCompanies(): Response
    {
        return Inertia::render('Companies/Create');
    }

    public function company(): Response
    {
        return Inertia::render('Companies/Show');
    }

    public function editCompanies(): Response
    {
        return Inertia::render('Companies/Edit');
    }

    public function listClients(): Response
    {
        return Inertia::render('Clients/Index');
    }

    public function createClients(): Response
    {
        return Inertia::render('Clients/Create');
    }

    public function Client(): Response
    {
        return Inertia::render('Clients/Show');
    }

    public function editClients(): Response
    {
        return Inertia::render('Clients/Edit');
    }

    public function activeOrder(): Response
    {
        return Inertia::render('Orders/ActiveOrder');
    }
}
