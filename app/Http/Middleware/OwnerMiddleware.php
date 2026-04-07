<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OwnerMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        
        if (auth()->user()->role !== 'owner') {
            abort(403, 'Accès non autorisé');
        }
        
        return $next($request);
    }
}