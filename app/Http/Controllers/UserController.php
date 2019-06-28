<?php

namespace App\Http\Controllers;

use JWTAuth;
use Validator;
use Hash;
use App\User;
use App\Rol;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Tymon\JWTAuth\Exceptions\JWTException;


class UserController extends Controller
{
    public function __construct() {
        $this->middleware(
            ['jwt.auth', "roles.go:coordinador"], 
            ['except' => ['login', 'store']]
        );
        $this->middleware('jwt.refresh')->only('refresh');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::paginate();
        foreach ($users as $user) {
            $user->rol;
        }
        
        return response()->json($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try { $userOn = JWTAuth::parseToken()->authenticate(); } catch (\Throwable $th) {}

        $valiData = [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ];

        if (isset($userOn) && $userOn->rol->name == 'coordinador') {
            $valiData['rol_id'] = 'required|in:1,2,3';
        }

        $v = Validator::make($request->all(), $valiData);
        if ($v->fails())
        {
            return response()->json(['error' => $v->errors()], 400);
        }

        $user =  [
            'name'=> $request->name,
            'email'=> $request->email,
            'password'=> Hash::make($request->password)
        ];
        $user['rol_id'] = isset($userOn) && $userOn->rol_id == 1 ? $request->rol_id : 3;

        try {
            User::create($user);
        } catch (QueryException $e){
            $errorCode = $e->errorInfo[1];
            $res = ['error' => ''];
            
            switch ($errorCode) {
                case 1062:
                    $res['error']='email_already_exists';
                    break;
                case 1452:
                    $res['error']='invalid_rol';
                    break;
                default:
                    $res['error']=$e->errorInfo;
                    break;
            }
            return response()->json($res, 400);
        }

        return response()->json($user);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $user->rol;
        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $v = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email'
        ]);
        if ($v->fails())
        {
            return response()->json(['error' => $v->errors()], 400);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->rol_id = $request->rol_id;

        try {
            $user->save();
        } catch (QueryException $e){
            $errorCode = $e->errorInfo[1];
            $res = ['error' => ''];
            
            switch ($errorCode) {
                case 1062:
                    $res['error']='email_already_exists';
                    break;
                case 1452:
                    $res['error']='invalid_rol';
                    break;
                default:
                    $res['error']=$e->errorInfo;
                    break;
            }
            return response()->json($res, 400);
        }

        $user->rol;
        return response()->json($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        try {
            $user->delete();
        } catch (QueryException $e){
            return response()->json(['error' => $e->errorInfo], 400);
        }

        return response()->json($user);
    }

    /**
     * Login.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        try
        {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return response()->json(compact('token'));
    }

    /**
     * refresh token
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function refresh(Request $request)
    {
        return response()->json("Success");
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function readRoles()
    {
        return response()->json(Rol::get());
    }
}
