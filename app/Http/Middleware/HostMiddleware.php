<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HostMiddleware
{
    public function handle(Request $request, Closure $next)
{
    if (!Auth::check() || (Auth::user()->role !== 'host' && !Auth::user()->is_admin)) {
        return redirect('/')->with('error', 'Nemate pristup ovoj stranici.');
    }
    return $next($request);
}
}