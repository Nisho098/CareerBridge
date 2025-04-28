<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Log;

class Authenticate extends Middleware
{
    protected function redirectTo($request)
    {
        if (!Auth::check()) {
            Log::info('User is not authenticated, flashing error message to session');
            session()->flash('error', 'You must login first to apply.');
            return route('loginUser');
        }
    }
}

    

    
    

