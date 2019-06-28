<?php

namespace App\Http\Middleware;

use Closure;
use App\User;

class ParamsRolMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $key, $rol)
    {
        $user = $request->route($key);
        if ($user->rol->name != $rol) {
            return response()->json(['error' => 'invalid_'.$key], 400);
        }

        return $next($request);
    }
}
