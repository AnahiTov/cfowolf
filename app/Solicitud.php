<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{
    //
    // protected $dates = ['fecha_solicitud','fecha_desembolso','fecha_primer_pago', 'fecha_vencimiento', 'fecha_pagos'];
    protected $table = 'solicituds';
    protected $guarded = [];

    public function asociado (){
        return $this->hasOne(Asociado::class, 'id', 'asociado_id');
    }

    public function cliente (){
        return $this->hasOne(Cliente::class, 'id', 'cliente_id');
    }

    public function usuario (){
        return $this->hasOne(User::class, 'id', 'users_id');
    }

    public function personal (){
        return $this->hasOne(Personal::class, 'id', 'personals_id');
    }

    public function producto (){
        return $this->hasOne(Producto::class, 'id', 'producto_id');
    }

    public function analisis (){
        return $this->belongsTo(Analisis_credito::class, 'id', 'solicituds_id');
    }
    
    public function scopeName ($query, $name){
        if($name)
        return $query->orWhereRaw("CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) LIKE '%$name%' ");
    }
}
