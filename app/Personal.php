<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{
    protected $table = 'personals';

    public function getFullName (){
        return "{$this->nombre} {$this->apellido_paterno} {$this->apellido_materno}";
    
    }
    public function getName (){
        return "{$this->nombre} {$this->apellido_paterno}";
    }

    public function puesto (){
        return $this->belongsTo(Puesto::class, 'puesto', 'puesto');
    }

    public function puestoid (){
        return $this->hasOne(Puesto::class, 'id', 'puesto');
    }

    public function Namepuesto (){
        return $this->belongsTo(Puesto::class, 'puesto', 'puesto');
    }

    public function estadoNac (){
        return $this->hasOne(EstadoNacimiento::class, 'clave', 'estados_nacimientos_id');
    }

    public function sucursal (){
        return $this->hasOne(SucursalRuta::class, 'id', 'sucursales_id');
    }

    public function scopeName ($query, $name){
        if($name)
        // return $query->where('nombre','LIKE', "%$name%");
        return $query->orWhereRaw("CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) LIKE '%$name%' ");
    }
     
}
