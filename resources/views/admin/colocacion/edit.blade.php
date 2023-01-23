@extends('layouts.AdminLTE.index')
@section('title', 'Colocacion')
@section('header', 'Colocacion')
@section('content')
<div class="col-md-12">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4">
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <h3 class="profile-username text-center">{{$solicitud->cliente->getFullName()}}</h3>
                            <p class="text-muted text-center">{{$solicitud->personal->sucursal->nombre_ruta}}</p>
                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>{{$solicitud->primaSuma->productoSolicitud->nombre}}</b> <a class="float-right"></a>
                                </li>
                                <li class="list-group-item">
                                    <b>Periodo</b> <a class="float-right">{{$solicitud->primaSuma->periodo->descripcion}}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Suma Asegurada</b> <a class="float-right">$ {{$solicitud->primaSuma->suma_asegurada}}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Monto</b> <a class="float-right">$ {{$solicitud->primaSuma->monto}}</a>
                                </li>
                            </ul>
                            {{-- <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a> --}}
                        </div>
                    </div>
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Expediente</h3>
                        </div>

            
                        <div class="card-body">
                            <div class="col-sm-12">
                                <table class="table table-striped table-valign-middle">
                                    <thead>
                                    <tr>
                                      <th>INE</th>
                                      <th>Poliza</th>
                                      <th>Endoso</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>
                                            @if ($solicitud->ine == '')
                                                <img src="{{ asset('img/ban.png') }}" style="width:30px;height:30px;" title="Sin documento" alt="">
                                            @else
                                                @php 
                                                    $ext = explode('.', $solicitud->ine);
                                                @endphp

                                                
                                                @if($ext[1] == 'pdf')
                                                    <a target="_blank" href="{{asset($solicitud->ine)}}"><img id="logo" src="{{ asset('img/id-card.png') }}" style="width:30px;height:30px;cursor: pointer" ></a>
                                                @else
                                                    <img src="{{ asset('img/id-card.png') }}" style="width:30px;height:30px;cursor: pointer" onclick="verIneBenefToc('{{ $solicitud->ine }}')" title="Click para ver INE" alt="">
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                            @if ($solicitud->poliza == '')
                                                <img src="{{ asset('img/contract.png') }}" style="width:30px;height:30px;" title="Sin documento" alt="">
                                            @else
                                                @php 
                                                    $extPoliza = explode('.', $solicitud->poliza);
                                                @endphp

                                                
                                                @if($extPoliza[1] == 'pdf')
                                                    <a target="_blank" href="{{asset($solicitud->poliza)}}"><img id="logo" src="{{ asset('img/contract.png') }}" style="width:30px;height:30px;cursor: pointer" ></a>
                                                @else
                                                    <img src="{{ asset('img/id-card.png') }}" style="width:30px;height:30px;cursor: pointer" onclick="verIneBenefToc('{{ $solicitud->poliza }}')" title="Click para ver INE" alt="">
                                                @endif
                                            @endif
                                        </td>
                                      <td><img src="{{ asset('img/ban.png') }}" style="width:30px;height:30px;" title="Sin documento" alt=""></td>
                                     
                                    </tbody>
                                  </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Detalles</a></li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="activity">
                                    <div class="post">
                                        <span class="float-right">Fecha Venta:  {{ date('d/m/Y', strtotime($solicitud->fecha_venta))}}</span>
                                        <br>
                                        <form class="form-horizontal" method="POST" action="{{action('ColocacionController@update', $solicitud->id)}}" autocomplete="off">
                                            @method('PUT')	
                                            @csrf
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="txt_producto">Producto</label>
                                                    <select type="select" id="txt_producto" name="txt_producto" class="form-control @error('state') is-invalid @enderror" required onchange="cargarPeriodo()">
                                                        <option value="">Selecciona</option>
                                                      
                                                        @foreach($productos as $prod)
                                                            <option {{ old('txt_producto') == $prod->id ? 'selected' : ($selectProducto != "N/A" ? ($selectProducto == $prod->id ? 'selected' : '')  : '') }} value="{{$prod->id}}">{{$prod->nombre}}</option>                                                            
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="txt_periodo" class="">Periodo</label>
                                                    <select type="select" id="txt_periodo" name="txt_periodo" class="form-control select2 " required onchange="cargarMontos()">
                                                        <option value="">Selecciona</option>
                                                        @foreach($periodos as $periodo)
                                                        <option {{ old('txt_nombre_periodo') == $periodo->id ? 'selected' : ($selectPeriodo != "N/A" ? ($selectPeriodo == $periodo->id ? 'selected' : '')  : '') }} value="{{$periodo->id}}">{{$periodo->descripcion}}</option>
                                                    @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="txt_montos">Monto Asegurado</label>
                                                    <select type="select" id="txt_montos" name="txt_montos" class="form-control select2 " required onchange="cargarPrecio()">
                                                        <option value="">Selecciona</option>
                                                        @foreach($sumaAsegurada as $suma)
                                                        <option {{ old('txt_montos') == $suma->id_primasuma ? 'selected' : ($selectSuma != "N/A" ? ($selectSuma == $suma->id_primasuma ? 'selected' : '')  : '') }} value="{{$suma->id_primasuma}}">{{$suma->suma_asegurada}}</option>
                                                    @endforeach
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
                                       
                                            <div class="float-right">
                                                <div class="input-group input-group-sm mb-0 ">
                                                    <div class="input-group-append">
                                                        <button type="submit" class="btn btn-success ">Guardar</button>
                                                        <a type="button" href="{{ route('admin.colocacion.index') }}" class="btn btn-danger">Regresar</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        <br>
                                    </div>
                                    <div class="post clearfix">
                                        <div class="user-block">
                                            <img class="img-circle img-bordered-sm" src="{{ asset('img/group.png') }}" alt="User Image">
                                            <span class="username">
                                                <a href="#">BENEFICIARIOS</a>
                                                <a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a>
                                            </span>
                                        </div>

                                        <div class="row">
                                            <div class="col-12 table-responsive">
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Nombre Beneficiario</th>
                                                            <th>Parentesco</th>
                                                            <th>Porcentaje</th>
                                                        </tr>
                                                    </thead>
                                                <tbody>
                                                    @php
                                                        $cont = 1;
                                                    @endphp
                                                    @foreach($beneficiarios as $beneficiario)
                                                        <tr>

                                                            <td>{{ $cont }}.-</td>
                                                            <td>{{$beneficiario->nombre}} {{$beneficiario->apellido_paterno}} {{$beneficiario->apellido_materno}}</td>
                                                            <td>{{$beneficiario->parentesco}}</td>
                                                            <td>{{$beneficiario->porcentaje}}</td>
                                                        </tr>
                                                        @php
                                                            $cont ++;
                                                        @endphp
                                                    @endforeach
                                                </tbody>
                                                </table>
                                            </div>   
                                        </div>

                                       
                                       
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
<div class="modal fade" id="myPicture" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true" style="z-index: 2000">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-th-list"></i></h5>
                <div class="card-tools float-right">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                
            </div>
            <div class="modal-body">
                <div id="contPicture"></div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
    // cargarMontos();
    cargarPrecio();
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
                console.log(data.precios);
                $('#txt_precio').html('')
                $('#txt_precio').val(data.precios.monto);
                $('#txt_precio_dolar').html('')
                $('#txt_precio_dolar').val(data.precios.monto_dollar);
            }
        });

    }


    const verIneBenefToc = (archivo) => {
        $('#myPicture').modal();
        $("#exampleModalLabel").html(' <i class="fas fa-file-image-o fa-lg"></i> &nbsp; Imagenes')
        $("#contPicture").html(`<img src="{{ asset('${archivo}') }}" class="d-block w-100" alt="${archivo}" />`)
    }


    function verDocumentoFirmadoToc(solicitud){
        $('#contenido_modal').html('<iframe src="public/img/seguros/'+solicitud+'" width="100%" height="100%" scrolling="no"></iframe>');	
        AbrirModalGeneral('ModalPrincipal',1000,500);
    }
</script>
@endpush