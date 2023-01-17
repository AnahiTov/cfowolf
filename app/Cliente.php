<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes';

    protected $guarded = [];
    
    public function getFullName (){
        return "{$this->nombre} {$this->apellido_paterno} {$this->apellido_materno}";
    }

    public function asociados (){
        return $this->hasOne(Asociado::class, 'id', 'asociado_id');
    }

    public function solicitud (){
        return $this->belongsTo(Solicitud::class, 'id', 'cliente_id');
    }

    public function cuentas (){
        return $this->hasOne(Cuenta::class, 'id', 'cuentas_id');
    }

    public function aval (){
        return $this->hasOne(Aval::class, 'id', 'aval_id');
    }

    public function estadoNac (){
        return $this->hasOne(EstadoNacimiento::class, 'clave', 'estados_nacimientos_clave');
    }

    public function scopeName ($query, $name){
        if($name)
        return $query->orWhereRaw("CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) LIKE '%$name%' ");
    }
    
}
