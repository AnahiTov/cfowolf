<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'personals_id', 'roles_id', 'email', 'password','confirmation_code','confirmed',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

   
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    public function personal (){
        return $this->hasOne(Personal::class, 'id', 'personals_id');
    }

    public function rol (){
        return $this->hasOne(Rol::class, 'id', 'roles_id');
    }

    public function permisos (){
        return $this->hasMany(Permiso::class, 'roles_id', 'roles_id');
    }

}
