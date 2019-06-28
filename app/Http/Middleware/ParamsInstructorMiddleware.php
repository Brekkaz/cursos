<?php

namespace App\Http\Middleware;

use Closure;
use App\User;

class ParamsInstructorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $instructor = $request->route('instructor');
        if ($instructor->rol->name != 'instructor') {
            return response()->json(['error' => 'invalid_instructor'], 400);
        }

        return $next($request);
    }
}
