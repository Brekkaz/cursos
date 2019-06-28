<?php

namespace App\Http\Middleware;

use Closure;
use App\Course;


class InstructorCourseMiddleware
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
        $course = $request->route('course');

        $courseValidated = Course::where('id', $course->id)
        ->where('instructor_id', $instructor->id)
        ->first();

        if ($courseValidated==null) {
            return response()->json(['error'=>'course_isnot_of_instructor'], 400);
        }

        return $next($request);
    }
}
