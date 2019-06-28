<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table = 'rols';

    protected $fillable = [ 'name', 'description' ];

    protected $hidden = [
        'created_at', 'updated_at',
    ];

    public function users()
    {
        return $this->hasMany('App\User', 'rol_id', 'id');
    }
}
