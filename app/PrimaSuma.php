<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PrimaSuma extends Model
{

    protected $table = 'primas_sumas';


    // public function producto (){
    //     return $this->belongsTo(ProductoSeg::class, 'id', 'periodo_id');
    // }

    public function periodo (){
        return $this->hasOne(Periodo::class, 'id', 'periodo_id');
    }

    public function productoSolicitud (){
        return $this->hasOne(ProductosSeg::class, 'id', 'productoSeguro_id');
    }
}
