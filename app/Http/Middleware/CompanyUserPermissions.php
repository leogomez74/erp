<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CompanyUserPermissions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(\Auth::user()->type == 'EMPLOYEE' || (\Auth::user()->type == 'company'  && \Auth::user()->created_id==1 &&  \Auth::user()->created_by==1)){
            return redirect('/')->with('errors', __('Permission denied.'));
        }else{
            
            return $next($request);
        }
        
    }
}
