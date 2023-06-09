<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function chanceCompany(Request $request, $company = null): RedirectResponse
    {
        $user = Auth::loginUsingId($company);
        session(['companies_users' => true]);

        return redirect()->back()->with('success', __('Companies change successfully.'));
    }
}
