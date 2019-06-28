<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table = 'rols';

    protected $fillable = [ 'name', 'description' ];

    public function users()
    {
        return $this->hasMany('App\User', 'rol_id', 'id');
    }
}
