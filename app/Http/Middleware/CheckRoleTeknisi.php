<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRoleTeknisi
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && in_array(Auth::user()->role, ['Teknisi Baru', 'Teknisi Senior'])) {
            return $next($request);
        }

        if (Auth::check() && Auth::user()->role === 'Admin') {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('login');
    }
}
