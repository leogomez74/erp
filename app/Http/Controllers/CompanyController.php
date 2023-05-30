<?php

namespace App\Http\Controllers;

use App\Models\Companies;
use Illuminate\Http\Request;
use DB;
use Illuminate\Queue\SerializesModels;
use Auth;



class CompanyController extends Controller
{
    /**
     * @param  Request  $request
     * */

    public function chanceCompany(Request $request, $company=null){
      
        $user=Auth::loginUsingId($company);
        session(['companies_users' => true]);
        
        return redirect()->back()->with('success', __('Companies change successfully.'));
        
    }
}