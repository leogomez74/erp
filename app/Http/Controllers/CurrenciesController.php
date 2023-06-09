<?php

namespace App\Http\Controllers;

class CurrenciesController extends Controller
{
    public function index()
    {
        return view('currencies.index');
    }
}
