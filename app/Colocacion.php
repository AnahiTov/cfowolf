<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Colocacion extends Model
{
    //
    protected $table = 'solicitudseguros';

    public function scopeName ($query, $name){
        if($name)
        return $query->orWhereRaw("CONCAT(nombre, ' ',apellido_paterno, ' ',apellido_materno) LIKE '%$name%' ");
    }

    public function primaSuma (){
        return $this->hasOne(PrimaSuma::class, 'id_primasuma', 'primasuma_id');
    }

    public function cliente (){
        return $this->hasOne(Cliente::class, 'id', 'clientes_id');
    }

    public function personal (){
        return $this->hasOne(Personal::class, 'id', 'personals_id');
    }
}


