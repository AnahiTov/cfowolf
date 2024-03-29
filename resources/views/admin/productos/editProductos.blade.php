@extends('layouts.AdminLTE.index')
@section('title', 'Productos')
@section('header', 'Productos')
@section('content')
<div class="col-md-12">
    <div class="card card-gray">
        @if(Session::has('mensaje'))
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            {{Session::get('mensaje')}}
            </div>  
        @endif  
        <div class="card-header">
            <h4 class="card-title">
                Editar Producto
            </h4>
        </div>

        <form method="POST" action="{{action('ProductoController@update', $producto->id)}}" autocomplete="off">
        @method('PUT')	
        @csrf
        <div class="card-body">
            <div class="col-sm-10">
                <div class="form-group">
                    <label for="txt_nombre_producto">Nombre del Producto</label>
                    <input type="text" id="txt_nombre_producto" name="txt_nombre_producto" class="form-control text-uppercase" placeholder="Nombre del Producto" value="{{ $producto->nombre}}">
                </div>
            </div>
            <div class="d-flex justify-content-start">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="txt_frecuencia">Frecuencia de Pago</label>
                        <select class="form-control" id="txt_frecuencia" name="txt_frecuencia">
                            <option {{ $producto->frecuencia_pago == 'DIARIO' ? 'selected' : ''}} value="DIARIO">DIARIO</option>
                            <option {{ $producto->frecuencia_pago == 'SEMANAL' ? 'selected' : ''}} value="SEMANAL">SEMANAL</option>
                            <option {{ $producto->frecuencia_pago == 'QUINCENAL' ? 'selected' : ''}} value="QUINCENAL">QUINCENAL</option>
                            <option {{ $producto->frecuencia_pago == 'MENSUAL' ? 'selected' : ''}} value="MENSUAL">MENSUAL</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="txt_plazo">Plazo</label>
                        <input type="text" id="txt_plazo" name="txt_plazo" class="form-control text-uppercase" placeholder="plazo" value="{{ $producto->plazo}}" onchange="calculo();">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="txt_tasa">Tasa</label>
                        <input type="text" id="txt_tasa" name="txt_tasa" class="form-control text-uppercase" placeholder="Tasa" value="{{ $producto->tasa}}" onchange="calculo();">
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-start">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="txt_monto_prestamo">Monto del Prestamo</label>
                        <input type="text" id="txt_monto_prestamo" name="txt_monto_prestamo" class="form-control" placeholder="Monto del Prestamo" value="{{ $producto->monto_prestamo}}" onchange="calculo();">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="txt_nivel">Nivel</label>
                        <input type="text" id="txt_nivel" name="txt_nivel" class="form-control text-uppercase" placeholder="Nivel" value="{{ $producto->nivel}}">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="txt_monto_pago">Pago Semanal</label>
                        <input type="text" id="txt_monto_pago" name="txt_monto_pago" class="form-control" placeholder="Pago Semanal" value="{{ $producto->monto_pago}}">
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-start">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="txt_meses">Meses</label>
                        <input type="text" id="txt_meses" name="txt_meses" class="form-control" placeholder="Meses" value="{{ $producto->meses}}">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="txt_total">Total</label>
                        <input type="text" id="txt_total" name="txt_total" class="form-control" placeholder="Total" value="{{ $producto->total}}">
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-start">
                <div class="col-sm-5">
                    <div class="form-group">
                        <label for="txt_cuenta" class="">Cuenta Contable</label>
                        <select type="select" id="txt_cuenta" name="txt_cuenta" class="form-control select2 " required onchange="cargarNumCta()">
                            <option value="">Seleccionar</option>
                            @foreach($cuentas as $cuenta)
                                <option {{ old('txt_cuenta') == $cuenta->id ? 'selected' : ($opcionCuenta != "N/A" ? ($opcionCuenta == $cuenta->id ? 'selected' : '')  : '') }} value="{{$cuenta->id}}">{{$cuenta->nombre_cuenta}}</option>
                            @endforeach
                        </select>
                        @error('userType')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="txt_num_cuenta">Número de Cuenta</label>
                        <input type="text" id="txt_num_cuenta" name="txt_num_cuenta" class="form-control" readonly placeholder="Número de Cuenta">
                    </div>
                </div>
            </div>
        </div>              
        <div class="card-footer">
            <div class="col-12">
                <a type="button" href="{{ route('admin.producto.index') }}" class="btn btn-danger float-right">Cerrar</a>
                <button type="submit" class="btn btn-primary float-right" style="margin-right: 5px;">Guardar</button>
            </div>
        </div>
        </form>
    </div>
</div>
@endsection
@push('scripts')
<script>
    $.ajaxSetup({
        headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
    });

    $('[data-mask]').inputmask()

    $("#txt_cuenta").select2({
        theme:"bootstrap4"
    });

    $("#txt_monto_prestamo").maskMoney({
        decimal: ".",
        thousands: ","
    })

    $("#txt_monto_prestamo").maskMoney({
        decimal: ".",
        thousands: ","
    })

    cargarNumCta({{ $producto->cuentas_id}});
    

    function calculo(){
        let monto_prestamo = convertir($("#txt_monto_prestamo").val());
        let tasa = $("#txt_tasa").val();
        let plazo = $("#txt_plazo").val();
        let porcentaje = tasa * (1/100);

        if (isNaN(monto_prestamo) || isNaN(tasa) || isNaN(plazo)) {
            $("#txt_monto_pago").val("")
            $("#txt_total").val("")
        }else{   
            let formulaTotal = ((monto_prestamo * porcentaje) + monto_prestamo)
            let formulaMontoP= (formulaTotal / plazo)
            let resultadoT = formulaTotal.toFixed(2)
            let resultadoMp = formulaMontoP.toFixed(2)
            $("#txt_total").val(resultadoT)
            $("#txt_monto_pago").val(resultadoMp)
        }
    }

    function cargarNumCta(id){
        $.ajax({
            url: "{{ asset('admin/productos/numCuenta') }}/" + id,
            type: 'get',
            cache: false,
            beforeSend(){

            },
            success: function(data){
               console.log(data);
                $('#txt_num_cuenta').val(data.cuenta.numero_cuenta);
                
            }
        });
    }
</script>
@endpush