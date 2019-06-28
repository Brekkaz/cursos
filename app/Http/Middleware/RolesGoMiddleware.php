<?php

namespace App\Http\Middleware;

use Closure;

class RolesGoMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$roles)
    {
        $userOn = auth()->user();
        if (!in_array($userOn->rol->name, $roles)) {
            return response()->json(['error' => 'invalid_credentials'], 401);
        }

        return $next($request);
    }
}
