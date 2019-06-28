<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseStudent extends Model
{
    protected $table = 'course_students';

    protected $fillable = [ 'course_id', 'student_id', ];

    public function course(){
        return $this->belongsTo('App\Course', 'course_id', 'id');
    }

    public function student(){
        return $this->belongsTo('App\User', 'student_id', 'id');
    }
}
