<?php

namespace App\Http\Middleware;

use Closure;

class RolMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $rol)
    {
        $userOn = auth()->user();
        if ($userOn->rol->name != $rol) {
            return response()->json(['error' => 'invalid_credentials'], 401);
        }

        return $next($request);
    }
}
