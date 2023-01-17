@extends('layouts.AdminLTE.index')

@section('title', 'Colocacion')
@section('header', 'Colocacion')

@section('content')
    
    <div class="card">
        <div class="card-header with-border">
            <h3 class="card-title">Lista de Solicitudes</h3>
            <div class="card-tools pull-right">
                <a href="{{ route('admin.colocacion.create') }}"  type="button" class="btn btn-sm btn-primary" title="Agregar Solicitud"><li class="fas fa-plus"></li>&nbsp; Nueva Solicitud</a>
            </div>
        </div>
        <div class="card-body">
            <form class="form-horizontal" autocomplete="off">
                <div class="form-group row text-right">
                    <div class="col-sm-4">
                        <input type="text" class="form-control form-control-sm text-uppercase" placeholder="Introduce nombre a buscar " id="txt_name" name="txt_name" value="{{$name}}">    
                    </div> 
                    <div class="col-sm-2 text-left">
                        <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-search-plus"></i>&nbsp; Buscar</button>
                    </div>
                </div>
            </form>
            {{-- <div class="form-group float-right">
                <div class="d-flex">
                    <form action="{{ route('admin.solicitud.index') }}">
                        @csrf
                        <input type="hidden" id="estatus" name="estatus" value="Pendiente">
                        <button type="submit" class="btn btn-app">
                            <span class="badge bg-warning">{{$statePendiente->count()}}</span>
                            <i class="fas fa-ban"></i> Pendiente
                        </button>
                    </form>
                    <form action="{{ route('admin.solicitud.index') }}">
                        @csrf
                        <input type="hidden" id="estatus" name="estatus" value="Proceso">
                        <button type="submit" class="btn btn-app">
                            <span class="badge bg-info">{{$stateProceso->count()}}</span>
                            <i class="fas fa-sync fa-spin"></i> Proceso
                        </button>
                    </form>
                    <form action="{{ route('admin.solicitud.index') }}">
                        @csrf
                        <input type="hidden" id="estatus" name="estatus" value="Autorizado">
                        <button type="submit" class="btn btn-app">
                            <span class="badge bg-success">{{$stateTerminado->count()}}</span>
                            <i class="fas fa-check-circle"></i> Autorizado
                        </button>
                    </form>
                </div>
            </div> --}}
            <table class="table table-striped projects">
                <thead>
                    <tr>
                        <th>ID solicitud</th>
                        <th>Cliente</th>
                        <th>Periodo</th>
                        <th>Monto </th>
                        <th>Fecha Solicitud</th>
                        <th>Estatus</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($solicitudes as $solicitud)
                    
                    <tr>
                        <td># {{ $solicitud->id }}</td>
                        <td>{{ $solicitud->cliente->getFullName() }}</td>
                        <td>{{ $solicitud->primaSuma->periodo->descripcion}}</td>
                        <td>{{ number_format($solicitud->primaSuma->suma_asegurada,2,'.',',') }}</td>
                        <td>{{ date('d/m/Y', strtotime($solicitud->fecha_solicitud))}}</td> 
                        @if ($solicitud->estado_solseg == 'Pendiente')
                            <td><small class="badge badge-warning"><i class="far fa-clock"></i> {{ $solicitud->estado_solseg }}</small></td>
                          
                        @elseif($solicitud->estado_solseg == 'Proceso')
                            <td><small class="badge badge-info"><i class="fas fa-check"></i> {{ $solicitud->estado_solseg }}</small></td>
                          
                        @elseif($solicitud->estado_solseg == 'Terminado')
                            <td><small class="badge badge-success"><i class="fas fa-check"></i> {{ $solicitud->estado_solseg }}</small></td>
                           
                        @elseif($solicitud->estado_solseg == 'Rechazado')
                            <td><small class="badge badge-danger">{{ $solicitud->estado_solseg }}</small></td>
                           
                        @endif
                        <td>
                            <a class="btn btn-info btn-sm mr-2" href="{{ route('admin.colocacion.edit', [$solicitud->id]) }}"><i class="fas fa-eye"></i> Ver</a>
                            <a class="btn btn-info btn-sm mr-2" href="#modal-poliza" data-toggle="modal" onclick="upPolizaFasegToc('{{ $solicitud->id }}','{{ $solicitud->cliente->id }}')" class="btn btn-default btn-xs" title="Subir Poliza y detalles de la vigencia"><i class="fas fa-cloud-upload-alt"></i>&nbsp; Poliza</a>

                        </td>
                        {{-- <td class="project-actions text-right">
                            <button class="btn btn-info btn-sm"><i class="fas fa-ban"></i></button>
                        </td> --}}
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="float-right">{{ $solicitudes->appends(request()->query())->links()}}</div>
        </div>
    </div>
@endsection


<div class="modal fade show" id="modal-poliza" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" action="{{ route('admin.cargarPoliza') }}" autocomplete="off"  enctype="multipart/form-data">
                @csrf
            <input type="hidden" id="solicitud" name="solicitud" value="0">
            <input type="hidden" id="cliente" name="cliente" value="0">
            <div class="modal-header">
                <h4 class="modal-title">Subir Poliza</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    {{-- <label class="col-sm-3 control-label text-right" for="customFileComporbante">Poliza</label> --}}
                    <div class="col-sm-7">
                        <label for="txt_producto" for="poliza">Poliza</label>
                        <div class="custom-file" style="cursor: pointer">
                            <input type="file" class="custom-file-input" id="poliza" name="poliza" accept="application/pdf">
                            <label class="custom-file-label" for="customFile">Buscar archivo</label>
                        </div>
                    </div>  
                    <div class="col-sm-2">
                        <label for="doc">Archivo</label>

                        <div class="image" id="doc" style="width: 120px">
                          <img class="img-thumbnail"  src="{{ asset('img/icon-nulo.png') }}" title="Documentos" width="40px">
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="txt_producto">Producto</label>
                            <select type="select" id="txt_producto" name="txt_producto" class="form-control @error('state') is-invalid @enderror" required onchange="cargarPeriodo()">
                                <option value="">Selecciona</option>
                                @foreach($productoSeg as $prod)
                                    <option {{ old('txt_producto') == $prod->id ? 'selected' : '' }} value="{{$prod->id}}">{{$prod->nombre}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="txt_periodo" class="">Periodo</label>
                            <select type="select" id="txt_periodo" name="txt_periodo" class="form-control select2 " required onchange="cargarMontos()">
                                <option value="">Selecciona</option>
                                
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="txt_montos">Monto Asegurado</label>
                            <select type="select" id="txt_montos" name="txt_montos" class="form-control @error('state') is-invalid @enderror" required onchange="cargarPrecio()">
                                <option value="">Selecciona</option>
                              
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="txt_precio">Precio</label>
                            <input type="text" id="txt_precio" name="txt_precio" class="form-control text-uppercase" placeholder="Precio">
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="txt_precio_dolar">Precio Dolar</label>
                            <input type="text" id="txt_precio_dolar" name="txt_precio_dolar" class="form-control text-uppercase" placeholder="Precio Dolar">
                        </div>
                    </div>
                    
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="txt_fventa">Fecha Venta</label>
                            <input type="date" id="txt_fventa" name="txt_fventa" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" placeholder="dd/mm/yyyy">

                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="txt_consentimiento">Numero de Consentimiento</label>
                            <input type="text" id="txt_consentimiento" name="txt_consentimiento" class="form-control text-uppercase" placeholder="Numero de consentimiento">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
            </form>
        </div>
    </div>
    
</div>

@push('scripts')
<script>

$('#txt_fventa').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })


function cargarPeriodo(){
    let idProducto = document.getElementById("txt_producto").value;
    $.ajax({
        url: "{{ asset('admin/colocacion/periodoSeg') }}/" + idProducto,
        type: 'get',
        cache: false,
        beforeSend(){

        },
        success: function(data){
            let selectPeriodos = '<option value="">-- Selecciona --</option>';
            data.periodos.forEach(fila =>  {
                selectPeriodos += '<option value="'+fila.id+'">'+fila.descripcion+'</option>';
            })
            $("#txt_periodo").html(selectPeriodos);
        }
    });
}


function cargarMontos(){
    let idProducto = document.getElementById("txt_producto").value;
    let idPeriodo = document.getElementById("txt_periodo").value;
    csrfc = $('meta[name="csrf-token"]').attr('content')

    $.ajax({
        type: 'POST',
        url: '/admin/colocacion/verMontosProducto',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        dataType:"json",
        data: {
            _token: csrfc,
            idProducto : idProducto,
            idPeriodo : idPeriodo,
        },
    
        success: function(data){
           console.log(data);
           let selectMontos = '<option value="">-- Selecciona --</option>';
            data.montos.forEach(fila =>  {
                selectMontos += '<option value="'+fila.id_primasuma+'">'+fila.suma_asegurada+'</option>';
            })
            $("#txt_montos").html(selectMontos); 

        }
    });
   
}



function cargarPrecio(){

    let idPrimaSuma = document.getElementById("txt_montos").value;
    $.ajax({
        url: "{{ asset('admin/colocacion/montoSumaAseg') }}/" + idPrimaSuma,
        type: 'get',
        cache: false,
        beforeSend(){

        },
        success: function(data){
            $('#txt_precio').html('')
            $('#txt_precio').val(data.precios.monto);
            $('#txt_precio_dolar').html('')
            $('#txt_precio_dolar').val(data.precios.monto_dollar);
        }
    });

}


$("#poliza").on('change',function(e){
        let files = e.target.files; // FileList object
        // Obtenemos la imagen del campo "file".
        for (var i = 0, f; f = files[i]; i++) {
            if(f.size <= 18000000){
                if (!f.type.match('image.*')) {
                    //continue;
                    if(document.getElementById("doc")){
                        document.getElementById("doc").innerHTML = '<img class="img-thumbnail" src="{{ asset('img/png-icon.png') }}" width="40px" title="Imagen"/>';
                    }
                }
            }else{
                document.getElementById('poliza').value = ''
                Swal.fire({
                    type: 'error',
                    title: 'Archivo demasiado pesado.',
                    html: '<h3>Maximo soportado 18Mb</h3>',
                    showConfirmButton: false,
                    timer: 3000
                })
            }
        }
    })


    function upPolizaFasegToc(idSol, idCLiente){
    
        let idSolicitud  = parseInt(idSol);
        $("#modal-poliza #solicitud").val(idSol);
        $("#modal-poliza #cliente").val(idCLiente);
      

    }
</script>
@endpush