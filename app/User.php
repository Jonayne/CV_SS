<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /** 
     * Un usuario puede tener varios roles.
     */ 
    public function roles(){
        return $this->belongsToMany('App\Role');
    }

    /**
     * Un usuario tiene solo un curriculum.
     */
    public function curriculum(){
        return $this->hasOne('App\Curriculum');
    }

   /**
     * Un usuario puede haber cursado varios cursos extracurriculares.
     */
    public function extracurricularCourses(){
        return $this->hasMany('App\ExtracurricularCourse');
    } 
    

    public function subjects(){
        return $this->hasMany('App\Subject');
    } 

    public function previousExperiences(){
        return $this->hasMany('App\PreviousExperience');
    } 

    /**
     * Un usuario puede tener varios documentos probatorios.
     */
    public function supportingDocuments(){
        return $this->hasMany('App\SupportingDocument');
    }

    /**
     * Nos dice si este usuario cumple con alguno de los roles del array.
     * 
     * @var array
     */
    public function hasAnyRoles($roles){

        if($this->roles()->
            whereIn('nombre_rol', $roles)->first()){
                return true;
        }
        
        return false;
    }

    /**
     * Nos dice si este usuario tiene este rol.
     * 
     * @var string
     */
    public function hasRole($role){

        if($this->roles()->
            where('nombre_rol', $role)->first()){
                return true;
        }
        
        return false;
    }

}
