<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('users/roles', 'UserController@readRoles')->name('users.roles');
Route::apiResource('users', 'UserController');
Route::post('login', 'UserController@login')->name('users.login');
Route::put('login', 'UserController@refresh')->name('users.refresh');

Route::apiResource('instructors.courses', 'CourseController');
Route::get('instructors', 'CourseController@instructors')->name('courses.instructors');
Route::post('enrollment/courses/{course}/students/{student}', 'CourseController@enrollment')->name('courses.enrollment');