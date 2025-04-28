<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class StudentRole
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

        if (auth()->user()->role !== 'student') {
            auth()->logout();
            return redirect('/')->withErrors('Student access only.');
        }
        return $next($request);
    }
}
