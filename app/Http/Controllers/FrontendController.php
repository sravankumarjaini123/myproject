<?php

namespace App\Http\Controllers;

class FrontendController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function products()
    {
        return view('products.index');
    }

    public function productShow($id)
    {
        return view('products.show', compact('id'));
    }

    public function cart()
    {
        return view('cart.index');
    }
}