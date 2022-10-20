<?php

namespace App\Http\Middleware;

use Closure;
use App\Submenu;
use App\User;

use Illuminate\Support\Facades\Request;
class PermisosMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    // public function handle($request, Closure $next)
    // {

       
            
    //     if (!auth()->check()) {
    //         return false;
    //     }
    //     $usuario_id = auth()->user()->id;
    //     $usuario = User::where('id', $usuario_id)->first();

    //     $submenus_id = $usuario->permisos->pluck('sub_menus_id')->toArray();
    //     $menu_id = \App\Submenu::WhereIn('id',$submenus_id)->pluck('route')->toArray();

    //     foreach($menu_id as $subitem){  
    //         $nombreRuta = Request::route()->getName();
    //         // dd($subitem, $nombreRuta);
    //         for($i=0;$i<count($submenus_id);$i++) {
    //             if($nombreRuta==$subitem) {
    //                 return $next($request);
    //             }
                
    //         }
    //     }
    //     // abort(404);
    //     return back();
    // }  


    public function handle($request, Closure $next)
    {       
        if (!auth()->check()) {
            return false;
        }
        $usuario_id = auth()->user()->id;
        $usuario = User::where('id', $usuario_id)->first();

        $submenus_id = $usuario->permisos->pluck('sub_menus_id')->toArray();
        $menu_id = \App\Submenu::WhereIn('id',$submenus_id)->pluck('route')->toArray();
        $nombreRuta = Request::route()->action['as'];
        $array2 = explode(".", $nombreRuta);

        foreach($menu_id as $subitem){  
            $nombreRuta = $array2[0].'.'.$array2[1].'.index';
            for($i=0;$i<count($submenus_id);$i++) {
                if($nombreRuta==$subitem) {
                    return $next($request);
                } 
            }
        }
        abort(404);
    }
}
