<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureCounselor
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user() || ! $request->user()->isCounselor()) {
            abort(403, 'This area is for the guidance counselor only.');
        }

        return $next($request);
    }
}