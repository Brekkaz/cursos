<?php

namespace App\Http\Controllers;

use Validator;
use App\Course;
use App\User;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function __construct() {
        $this->middleware(['jwt.auth', 'params.instructor:<User>'], 
        ['except' => ['instructors']]);
        
        $this->middleware('roles.go:instructor')
        ->only(['store','update','destroy']);

        $this->middleware('instructor.course:<User>,<Course>')
        ->only(['show','update','destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $instructor)
    {
        $courses = Course::where('instructor_id', $instructor->id)
        ->paginate();
        foreach ($courses as $course) {
            $course->instructor;
        }
        return response()->json($courses);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(User $instructor, Request $request)
    {
        $v = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'hours' => 'required|numeric'
        ]);
        if ($v->fails())
        {
            return response()->json(['error' => $v->errors()], 400);
        }

        $course =  [
            'name'=> $request->name,
            'description'=> $request->description,
            'hours'=> $request->hours,
            'description'=> $request->description,
            'instructor_id'=> $instructor->id
        ];

        try {
            Course::create($course);
        } catch (QueryException $e){
            $errorCode = $e->errorInfo[1];
            $res = ['error' => ''];
            
            switch ($errorCode) {
                case 1452:
                    $res['error']='invalid_instructor';
                    break;
                default:
                    $res['error']=$e->errorInfo;
                    break;
            }
            return response()->json($res, 400);
        }

        return response()->json($course);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $instructor, Course $course)
    {
        $course->instructor;
        return response()->json($course);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(User $instructor, Course $course, Request $request)
    {
        $v = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'hours' => 'required|numeric'
        ]);
        if ($v->fails())
        {
            return response()->json(['error' => $v->errors()], 400);
        }

        $course->name = $request->name;
        $course->description = $request->description;
        $course->hours = $request->hours;

        try {
            $course->save();
        } catch (QueryException $e){
            return response()->json(['error'=>$e->errorInfo], 400);
        }

        $course->instructor;
        return response()->json($course);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $instructor, Course $course)
    {
        try {
            $course->delete();
        } catch (QueryException $e){
            return response()->json(['error' => $e->errorInfo], 400);
        }

        return response()->json($course);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function instructors()
    {
        $instructors = User::where('rol_id', 2)
        ->paginate();
        foreach ($instructors as $instructor) {
            $instructor->rol;
        }
        return response()->json($instructors);
    }
}
