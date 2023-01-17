<?php

namespace App\Http\Controllers;
use App\Colocacion;
use App\ProductosSeg;
use App\Cliente;
use App\PrimaSuma;
use App\Personal;
use App\Referencia;
use App\Prospecto;
use App\Archivo;
use File;


use Illuminate\Http\Request;

class ColocacionController extends Controller
{
    //

    public function index(Request $request)
    {
        $name =  mb_strtoupper($request->get('txt_name'), 'UTF-8');
       
        if($request->estatus){
            $solicitudes = Colocacion::select('solicitudseguros.*')->where('solicitudseguros.estado_solseg', $request->estatus) ->name($name)
            ->join('clientes', 'clientes.id', '=', 'solicitudseguros.clientes_id')
            ->leftjoin('archivos', 'archivos.solicitudseguros_id', '=', 'solicitudseguros.id')
            ->paginate(10);
        }else{
            $solicitudes = Colocacion::select('solicitudseguros.*')
            ->name($name)
            ->join('clientes', 'clientes.id', '=', 'solicitudseguros.clientes_id')
            ->leftjoin('archivos', 'archivos.solicitudseguros_id', '=', 'solicitudseguros.id')
            ->paginate(10);
        }

      
        $productoSeg = ProductosSeg::all(); 
           

        return view('admin.colocacion.index', compact('solicitudes','name','productoSeg'));
    }


    public function create()
    {
        $prospectos = Cliente::where('tipo_cliente','Prospecto')->get();
        $productoSeg = ProductosSeg::all();
        $personal = Personal::all();
        return view('admin.colocacion.addSolicitudSeguro', compact('productoSeg','personal','prospectos'));

    }

    public function edit($id)
    {
        // $solicitud = Colocacion::where('id', $id)->first();

        // dd($id);
        $solicitud = Colocacion::select('solicitudseguros.*','archivos.ine')->where('solicitudseguros.id', $id)
        ->join('clientes', 'clientes.id', '=', 'solicitudseguros.clientes_id')
        ->leftjoin('archivos', 'archivos.solicitudseguros_id', '=', 'solicitudseguros.id')
        ->first();

        $productos = ProductosSeg::all(); 
        $selectProducto = "N/A";
        if($solicitud->primaSuma->productoSolicitud()->first('id') != null){
            $selectProducto = $solicitud->primaSuma->productoSolicitud()->first('id')->id;
        }
        
        $periodos = primaSuma::select('periodo.*')
        ->join('periodo', 'periodo.id', '=', 'primas_sumas.periodo_id')
        ->groupBy('periodo_id')
        ->get();

        if($solicitud->primaSuma->periodo()->first('id') != null){
            $selectPeriodo = $solicitud->primaSuma->periodo()->first('id')->id;
        }
        
        $sumaAsegurada = primaSuma::select('primas_sumas.*')
        ->where('periodo_id',$selectPeriodo)
        ->get();


        if($solicitud->primaSuma()->first('id_primasuma') != null){
            $selectSuma = $solicitud->primaSuma()->first('id_primasuma')->id_primasuma;
        }

        $beneficiarios = Referencia::where('clientes_id', $solicitud->clientes_id)->get();

        return view('admin.colocacion.edit', compact('solicitud','selectProducto','productos','periodos','selectPeriodo','sumaAsegurada','selectSuma','beneficiarios'));
    }

    public function store(Request $request)
    {
        //   dd($request);
        if($request->txt_nombre_prospecto){
            Cliente::where('id', $request->txt_nombre_prospecto)->update([
                'tipo_cliente' => 'Cliente',
            ]);

            // $prospecto = Cliente::findOrFail($request->txt_nombre_prospecto);
            // # Crear nuevo cliente
            // $cliente = new cliente;
            // $cliente->nombre = $prospecto->nombre;
            // $cliente->apellido_paterno = $prospecto->apellido_paterno;
            // $cliente->apellido_materno = $prospecto->apellido_materno;
            // $cliente->direccion = $prospecto->direccion;
            // $cliente->celular = $prospecto->telefono;
            // $cliente->fecha_nacimiento = $prospecto->fecha_nacimiento;
            // $cliente->edad = $prospecto->edad;
            // $cliente->genero = $prospecto->genero;
            // $cliente->curp = $prospecto->curp;
            // $cliente->referencia = $prospecto->referencia;
            // $cliente->entre_calles = $prospecto->entre_calles;
            // # Guardar el cliente
            // $cliente->save();
            // $IDCliente= $cliente["id"];
        }
        $IDCliente= $request->idCliente;

        


        $colocacion = new Colocacion();

        $colocacion->users_id = auth()->user()->id;
        if($IDCliente){
            $clienteId = $colocacion->clientes_id = $IDCliente;
        }else{
            $clienteId = $colocacion->clientes_id = $request->input('idCliente');
        }
        $colocacion->fecha_solicitud = date("Y-m-d");
        $colocacion->fecha_venta = date("Y-m-d");
        $colocacion->personals_id = $request->input('txt_coordinador');
        $colocacion->empleado_id_superv = $request->input('txt_supervisor');
        $colocacion->empleado_id_auditor = $request->input('txt_auditor');
        $colocacion->aseguradora = $request->input('txt_aseguradora');
        $colocacion->credito = $request->input('txt_credito');
        $colocacion->primasuma_id = $request->input('txt_montos'); /// aqui viene el id de la primasuma        
        $colocacion->estado_solseg = 'Terminado';
        $colocacion->save();
        $IDSol= $colocacion["id"];
        $fecha_venta = date("Y-m-d");
        $vigencia = $this->calcularVigencia($request->input('txt_periodo'), $fecha_venta);

        Colocacion::where('id', $IDSol)->update([
            'fecha_vigencia' => $vigencia
        ]);

        $archivos = new Archivo();

        if($files = $request->file('ine_anverso')) {
            $año = date('Y');
            $mes = date('m');
            $path = public_path('img/seguros/'.$año.'/'.$mes);

            if(!File::isDirectory($path)){
                File::makeDirectory($path, 0777, true, true);

            } 
            // $path = 'files/pdfEmpresa/'; // upload path
            $profilefile = 'Solicitud-'.$IDSol. "." . $files->getClientOriginalExtension();
            $files->move($path, $profilefile);
            $insert['ine'] = "$profilefile";
            // $archivos->ine = $insert['ine'];
            $archivos->ine = 'img/seguros/'.$año.'/'.$mes.'/'.$profilefile;
            $archivos->solicitudseguros_id = $IDSol;
            $archivos -> save();
        }

        // return redirect()->route('admin.colocacion.index');
        return $this->beneficiarios($clienteId,$IDSol);


    }


    public function beneficiarios($cliente,$IDSol)
    {
      
        $referencias = Referencia::where('clientes_id',$cliente)->get();

        return view('admin.colocacion.beneficiarios', compact('cliente','referencias','IDSol'));

        
    }

    public function guardarReferencias(Request $request){
        //   dd($request);
           $referencia = new Referencia();
           $idCliente = $request->idClienteRef;

           if($request->idReferencia == 0){
                $referencia->clientes_id = $request->idClienteRef;
                $referencia->nombre = mb_strtoupper($request->input('txt_nombre_ref'), 'UTF-8');
                $referencia->apellido_paterno = mb_strtoupper($request->input('txt_apellido_paterno_ref'), 'UTF-8');
                $referencia->apellido_materno = mb_strtoupper($request->input('txt_apellido_materno_ref'), 'UTF-8');
                $referencia->parentesco = mb_strtoupper($request->input('txt_parentesco_ref'), 'UTF-8');
                $referencia->telefono = $request->input('txt_celular_ref');
                $referencia->porcentaje = $request->input('txt_porcentaje');
                $referencia->direccion = mb_strtoupper($request->input('txt_direccion_ref'), 'UTF-8');
                $referencia->referencia = mb_strtoupper($request->input('txt_referencia_ref'), 'UTF-8');
                $referencia->entre_calles = mb_strtoupper($request->input('txt_entre_calles_ref'), 'UTF-8');
                $referencia->save();
           }else{
                Referencia::where('id', $request->idReferencia)->update([
                    'nombre' => mb_strtoupper($request->txt_nombre_ref , 'UTF-8'),
                    'apellido_paterno' => mb_strtoupper($request->txt_apellido_paterno_ref, 'UTF-8'),
                    'apellido_materno' => mb_strtoupper($request->txt_apellido_materno_ref , 'UTF-8'),
                    'parentesco' => mb_strtoupper($request->txt_parentesco_ref , 'UTF-8'),
                    'porcentaje' => $request->txt_porcentaje,
                    'telefono' => $request->txt_celular_ref,
                    'direccion' => mb_strtoupper($request->txt_direccion_ref,'UTF-8'),
                    'entre_calles' => mb_strtoupper($request->txt_entre_calles_ref,'UTF-8'),
                    'referencia' => mb_strtoupper($request->txt_referencia_ref,'UTF-8'),
                ]);
           }
        
            $countPorcentaje = Referencia::selectRaw('SUM(porcentaje) as total')->where('clientes_id', $idCliente)->get();
            if($countPorcentaje[0]->total == 100){
                Colocacion::where('id', $request->idSolicitud)->update([
                    'estado_solseg' => 'Terminado',
                ]);
                return redirect()->route('admin.colocacion.index');
            }else{
                return $this->beneficiarios($idCliente,$request->IDSol);
            }
        }

        
    public function obtenerDetallesCliente($curp){
        $curpstr = strtoupper($curp);
        $cliente = Cliente::where('curp','LIKE',"%$curpstr%")->first();
        return response()->json(["cliente" => $cliente]);
    }


    public function verPeriodo($idProducto){
        \DB::statement("SET SQL_MODE=''");
        $periodos = PrimaSuma::select('periodo.id','periodo.descripcion')
        ->where('productoSeguro_id', $idProducto)
        ->join('periodo', 'periodo.id', '=', 'primas_sumas.periodo_id')
        ->groupBy('primas_sumas.periodo_id')
        ->get();
        // $periodos = Personal::where('id', $idProducto)->first()->puestoid->areas;
        return response()->json(["periodos" => $periodos]);
    }

    public function detallesMontoSeg(Request $request){
        $montos = PrimaSuma::where('productoSeguro_id', $request->idProducto)->where('periodo_id',$request->idPeriodo)->get();
        return response()->json(["montos" => $montos]);
    }

    public function obtenerMonto($idPrimaSuma){
        // $precios = PrimaSuma::where('id_primasuma',$idPrimaSuma)->pluck('monto');
        $precios = PrimaSuma::where('id_primasuma',$idPrimaSuma)->first();
        return response()->json(["precios" => $precios]);
    }


    public static function calcularVigencia($periodo,$fecha){
        $vigencia='';
        switch ($periodo){
            case '4': ////MENSUAL
                $vigencia = static::sumarFecha($fecha, 1);
                break;
            case '5':///Bimestral
                $vigencia = static::sumarFecha($fecha, 2);
                break;
            case '1': //Trimestral
                $vigencia = static::sumarFecha($fecha, 3);
                break;
            case '6': ///Cuatrimestral
                $vigencia = static::sumarFecha($fecha, 4);
                break;
            case '2'://Semestral
                $vigencia = static::sumarFecha($fecha, 6);
                break;
            case '8'://Octomestral
                $vigencia = static::sumarFecha($fecha, 8);
                break;
            case '9'://Decamestral
                $vigencia = static::sumarFecha($fecha, 10);
                break;
            case '3'://Anual
                $vigencia = static::sumarFecha($fecha, 12);
                break;
            case '7'://Bianual
                $vigencia = static::sumarDosFecha($fecha,24);
                break;
            case '11':///Dieciocho meses
                $vigencia = static::sumarDosFechaDieciocho($fecha, 18);
                break;
        }
        return $vigencia;
    }

    public static function sumarFecha($fecha, $cant){
        $nuevafecha = strtotime("$fecha + $cant months");
        $nuevafecha = date ( 'Y-m-j' , $nuevafecha );
        return $nuevafecha;
    }

    public function update(Request $request, $id)
    {
        // dd($request);
        Colocacion::where('id', $id)->update([
            'primasuma_id' => $request->txt_montos     
        ]);
        return redirect()->route('admin.colocacion.edit',[$id])->with('mensaje', 'Se ha editado correctamente');
    }

    public function guardarPoliza(Request $request)
    {
        // dd($request);
        $colocacion = new Colocacion();
        $fecha_venta = $request->input('txt_fventa');
        $vigencia = $this->calcularVigencia($request->input('txt_periodo'), $fecha_venta);

        Colocacion::where('id', $request->solicitud)->update([
            'fecha_venta' => $fecha_venta,
            'fecha_vigencia' => $vigencia,
            'aseguradora' => 'Agroasemex',
            'estado_solseg' => 'Terminado',
            'num_consentimiento' => mb_strtoupper($request->txt_consentimiento , 'UTF-8'),
            'primasuma_id' => $request->txt_montos

        ]);

        Cliente::where('id', $request->cliente)->update([
            'tipo_cliente' => 'Cliente'
        ]);

        $archivos = new Archivo();
        $solicitudSeg = Colocacion::where('id',$request->solicitud)->first();
        
        if($files = $request->file('poliza')) {
            $fecha = explode('-', $request->input('txt_fventa'));
            
            $año = $fecha[0];
            $mes = $fecha[1];
            $grupo = $solicitudSeg->personal->sucursal->nombre_ruta;
            $path = public_path('img/seguros/'.$año.'/'.$mes.'/'.$grupo);

            if(!File::isDirectory($path)){
                File::makeDirectory($path, 0777, true, true);

            } 
            $profilefile = 'Solicitud-'.$request->solicitud. "." . $files->getClientOriginalExtension();
            $files->move($path, $profilefile);
            $insert['poliza'] = "$profilefile";
            $archivoSolici = Archivo::where('solicitudseguros_id',$request->solicitud)->first();

            if(!empty($archivoSolici)){
                Archivo::where('solicitudseguros_id', $request->solicitud)->update([
                    'poliza' => 'img/seguros/'.$año.'/'.$mes.'/'.$grupo.'/'.$profilefile    
                ]);
            }else{
                $archivos->poliza = 'img/seguros/'.$año.'/'.$mes.'/'.$grupo.'/'.$profilefile;
                $archivos->solicitudseguros_id = $request->solicitud;
                $archivos -> save();
            }  
        }
        return redirect()->route('admin.colocacion.index');


    }
}
