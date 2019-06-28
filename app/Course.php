<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = 'courses';

    protected $fillable = [ 'name', 'description', 'hours', 'instructor_id', ];

    public function instructor(){
        return $this->belongsTo('App\User', 'instructor_id', 'id');
    }

    public function students()
    {
        return $this->belongsToMany('App\User', 'course_students', 'course_id', 'student_id');
    }
}
