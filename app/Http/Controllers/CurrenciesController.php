<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class CurrenciesController extends Controller
{
    public function index(): View
    {
        return view('currencies.index');
    }
}
