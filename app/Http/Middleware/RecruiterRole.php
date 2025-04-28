<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RecruiterRole
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
        if (!auth()->check()) {
            return redirect()->route('Account.signin')->withErrors('Please login first.');
        }

        if (auth()->user()->role !== 'recruiter') {
            auth()->logout();
            return redirect('/')->withErrors('Recruiter access only.');
        }
        return $next($request);
    }
}
