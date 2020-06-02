<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Curriculum extends Model
{

    protected $guarded = [];

    // Un curriculum pertenece a solo un profesor.
    public function user(){
        return $this->belongsTo('App\User');
    }
}
