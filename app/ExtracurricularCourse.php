<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExtracurricularCourse extends Model {
    protected $guarded = [];
    
    // Un curso extracurricular pertenece a un usuario.
    public function user() {
        return $this->belongsTo('App\User');
    }
}
