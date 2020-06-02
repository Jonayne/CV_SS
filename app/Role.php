<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    // Un rol puede pertenecer a varios usuarios.
    public function users(){
        return $this->belongsToMany('App\User');
    }
}
