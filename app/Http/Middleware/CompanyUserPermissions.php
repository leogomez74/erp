<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CompanyUserPermissions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (\Auth::user()->type == 'EMPLOYEE' || (\Auth::user()->type == 'company' && \Auth::user()->created_id == 1 && \Auth::user()->created_by == 1)) {
            return redirect('/')->with('errors', __('Permission denied.'));
        } else {
            return $next($request);
        }
    }
}
