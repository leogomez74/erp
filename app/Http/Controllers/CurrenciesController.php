<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CurrenciesController extends Controller
{
    public function index()
    {
        return view('currencies.index');
    }
}
