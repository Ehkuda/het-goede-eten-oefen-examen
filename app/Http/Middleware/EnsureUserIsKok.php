<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsKok
{
    public function handle(Request $request, Closure $next): Response
    {

        if (! Auth::check() || Auth::user()->role !== 'kok') {

            abort(403, 'Alleen koks hebben toegang tot het receptenboek.');
        }

        return $next($request);
    }
}