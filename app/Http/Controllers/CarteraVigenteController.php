<?php

namespace App\Http\Controllers;

use App\Analisis_credito;
use Illuminate\Http\Request;

class CarteraVigenteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $name =  mb_strtoupper($request->get('txt_name'), 'UTF-8');
        if($request->estatus){
            $creditos = Analisis_credito::select('analisis_credito.*')
            ->where('analisis_credito.desembolso', $request->estatus)
            ->name($name)
            ->join('solicituds', 'solicituds.id', '=', 'analisis_credito.solicituds_id')
            ->join('clientes', 'clientes.id', '=', 'solicituds.cliente_id')
            ->paginate(10);
        }else{
            $creditos = Analisis_credito::select('analisis_credito.*')
            ->name($name)
            ->where('desembolso', 'Desembolsado')
            ->join('solicituds', 'solicituds.id', '=', 'analisis_credito.solicituds_id')
            ->join('clientes', 'clientes.id', '=', 'solicituds.cliente_id')
            ->paginate(10);
        }


        $statePendiente = Analisis_credito::where('desembolso', 'Pendiente')->get();
        $stateDsembolsado = Analisis_credito::where('desembolso', 'Desembolsado')->get();

        return view('admin.cartera_vigente.index', compact('creditos','name','statePendiente','stateDsembolsado'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
