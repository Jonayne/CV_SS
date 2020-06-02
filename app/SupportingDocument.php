<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SupportingDocument extends Model
{   
    protected $guarded = [];
    
    // Un documento probatorio pertenece a un solo usuario.
    public function user(){
        return $this->belongsTo('App\User');
    }
}
