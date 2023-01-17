@extends('layouts.AdminLTE.index')
@section('title', 'Personal')
@section('header', 'Personal')
@section('content')
<div class="col-md-12">
    <div class="card card-gray">
        <div class="card-header">
            <h4 class="card-title">
                Nuevo personal
            </h4>
        </div>
        <form method="POST" action="{{ route('admin.addpersonal') }}" autocomplete="off">
            @csrf
        <div class="card-body">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="txt_sucursal_ruta" class="">Sucursal</label>
                    <select type="select" id="txt_sucursal_ruta" name="txt_sucursal_ruta" class="form-control select2 ">
                        <option value="">Selecciona</option>
                        @foreach($rutas as $ruta)
                            <option {{ old('txt_sucursal_ruta') == $ruta->id ? 'selected' : '' }} value="{{$ruta->id}}">{{$ruta->nombre_ruta}}</option>
                        @endforeach
                    </select>
                    @error('userType')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="d-flex justify-content-start">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="txt_nombre">Nombre</label>
                        <input type="text" id="txt_nombre" name="txt_nombre" class="form-control text-uppercase" placeholder="Nombre">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="txt_apellido_paterno">Apellido Paterno</label>
                        <input type="text" id="txt_apellido_paterno" name="txt_apellido_paterno" class="form-control text-uppercase" placeholder="Apellido Paterno">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="txt_apellido_materno">Apellido Materno</label>
                        <input type="text" id="txt_apellido_materno" name="txt_apellido_materno" class="form-control text-uppercase" placeholder="Apellido Materno">
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-start">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="txt_fecha_nac">Fecha de Nacimiento</label>
                        <input type="text" id="txt_fecha_nac" name="txt_fecha_nac" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" placeholder="dd/mm/yyyy">
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="position-relative form-group" id="theAge">
                        <label for="txt_edad" class="">Edad</label>
                        <input name="txt_edad" id="txt_edad" type="text" value="{{ old('edad') }}" class="form-control" required>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="txt_genero">Género</label>
                        <select class="form-control" id="txt_genero" name="txt_genero">
                            <option value="M">Masculino</option>
                            <option value="F">Femenino</option>
                            <option value="x">Indistinto</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-start">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="txt_ciudad_nacimiento">Ciudad de Nacimiento</label>
                        <input type="text" id="txt_ciudad_nacimiento" name="txt_ciudad_nacimiento" class="form-control text-uppercase" placeholder="Ciudad de Nacimiento">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="txt_estado_nacimiento">Estado de Nacimiento</label>
                        <select type="select" id="txt_estado_nacimiento" name="txt_estado_nacimiento" class="form-control @error('state') is-invalid @enderror" required onchange="btGenCurp(this.form, '3');">
                            <option value="">Selecciona</option>
                            @foreach($estados_nac as $estados)
                                <option {{ old('txt_estado_nacimiento') == $estados->clave ? 'selected' : '' }} value="{{$estados->clave}}">{{$estados->nombre}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="txt_nacionalidad">Nacionalidad</label>
                        <input type="text" id="txt_nacionalidad" name="txt_nacionalidad" class="form-control text-uppercase" placeholder="Nacionalidad">
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-start">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="txt_curp">CURP</label>
                        <input type="text" id="txt_curp" name="txt_curp" class="form-control text-uppercase" placeholder="CURP" maxlength="18">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="txt_rfc">RFC</label>
                        <input type="text" id="txt_rfc" name="txt_rfc" class="form-control text-uppercase" placeholder="RFC" maxlength="13">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="txt_imss">IMSS</label>
                        <input type="text" id="txt_imss" name="txt_imss" class="form-control text-uppercase" placeholder="IMSS" minlength="11" maxlength="13">
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-start">
                <div class="col-sm-2">
                    <div class="form-group">
                        <label for="txt_tipo_vivienda">Tipo Vivienda</label>
                        <select class="form-control" id="txt_tipo_vivienda" name="txt_tipo_vivienda">
                            <option>Propia</option>
                            <option>Rentada</option>
                            <option>Familiar</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="txt_direccion">Dirección</label>
                        <input type="text" id="txt_direccion" name="txt_direccion" class="form-control text-uppercase" placeholder="Dirección">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="txt_residencia">Años de Residencia</label>
                        <input type="text" id="txt_residencia" name="txt_residencia" class="form-control text-uppercase" placeholder="Años de Residencia">
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-start">
                <div class="col-sm-8">
                    <div class="form-group">
                        <label for="txt_referencia">Referencia</label>
                        <input type="text" id="txt_referencia" name="txt_referencia" class="form-control text-uppercase" placeholder="Referencia">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group" id="theCp">
                        <label for="txt_codigo_postal">Codigo Postal</label>
                        <input type="text" id="txt_codigo_postal" name="txt_codigo_postal" class="form-control" placeholder="Codigo Postal">
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-start">
                <div class="col-sm-4">
                    <div class="form-group" id="theSuburb">
                        <label for="txt_colonia">Colonia</label>
                        <select name="txt_colonia" id="txt_colonia" class="form-control text-uppercase theSuburbs" required>
                            <option value=""> - </option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group" id="theCity">
                        <label for="txt_ciudad">Ciudad</label>
                        <input type="text" id="txt_ciudad" name="txt_ciudad" class="form-control" placeholder="Ciudad">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group" id="theState">
                        <label for="txt_estado">Estado</label>
                        <input type="text" id="txt_estado" name="txt_estado" class="form-control" placeholder="Estado">
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-start">
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="txt_celular">Celular</label>
                        <input type="text" id="txt_celular" name="txt_celular" class="form-control" placeholder="(999) 999-9999" data-inputmask='"mask": "(999) 999-9999"' data-mask>
                    </div>
                </div>
                {{-- <div class="col-sm-3">
                    <div class="form-group">
                        <label for="txt_puesto">Puesto</label>
                        <select class="form-control" id="txt_puesto" name="txt_puesto">
                            <option>Socio Fundador</option>
                            <option>Operador de Asociado</option>
                            <option>Asociado</option>
                            <option>Administrador</option>
                            <option>Contador</option>
                        </select>
                    </div>
                </div> --}}
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="txt_puesto" class="">Puesto</label>
                        <select type="select" id="txt_puesto" name="txt_puesto" class="form-control select2 " required>
                            <option value="">Selecciona</option>
                            @foreach($puestos as $puesto)
                                <option {{ old('txt_puesto') == $puesto->id ? 'selected' : '' }} value="{{$puesto->id}}">{{$puesto->puesto}}</option>
                            @endforeach
                        </select>
                        @error('userType')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="txt_fecha_alta">Fecha de Alta</label>
                        <input type="text" id="txt_fecha_alta" name="txt_fecha_alta" class="form-control" placeholder="dd/mm/yyyy" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="txt_escolaridad">Escolaridad</label>
                        <select class="form-control" id="txt_escolaridad" name="txt_escolaridad">
                            <option>Ninguna</option>
                            <option>Leer y Escribir</option>
                            <option>Preescolar</option>
                            <option>Primaria</option>
                            <option>Secundaria</option>
                            <option>Preparatoria</option>
                            <option>Licenciatura</option>
                            <option>Maestria</option>
                            <option>Doctorado</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-start">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="txt_profesion">Profesión</label>
                        <input type="text" id="txt_profesion" name="txt_profesion" class="form-control text-uppercase" placeholder="Profesión">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="txt_religion">Religión</label>
                        <select class="form-control" id="txt_religion" name="txt_religion">
                            <option>Sin Religion</option>
                            <option>Cristianismo</option>
                            <option>Budismo</option>
                            <option>Hinduismo</option>
                            <option>Testigo de Jehova</option>
                            <option>Presbiteriana</option>
                            <option>Catolica</option>
                            <option>Protestante</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="txt_estado_civil">Estado Civil</label>
                        <select class="form-control" id="txt_estado_civil" name="txt_estado_civil">
                            <option>Soltero(a)</option>
                            <option>Casado(a)</option>
                            <option>Union Libre</option>
                            <option>Divorciado(a)</option>
                            <option>Viuda(a)</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-start">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="txt_clave_elector">Clave de Elector</label>
                        <input type="text" id="txt_clave_elector" name="txt_clave_elector" class="form-control text-uppercase" placeholder="Clave de Elector" maxlength="18">
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label for="txt_vencimiento_ine">Año de vencimiento</label>
                        <input type="text" id="txt_vencimiento_ine" name="txt_vencimiento_ine" class="form-control" placeholder="aaaa" maxlength="4">
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="txt_folio_ine">Folio INE</label>
                        <input type="text" id="txt_folio_ine" name="txt_folio_ine" class="form-control text-uppercase" placeholder="Folio INE" maxlength="20">
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="txt_ocr">OCR</label>
                        <input type="text" id="txt_ocr" name="txt_ocr" class="form-control text-uppercase" placeholder="OCR" maxlength="13">
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-start">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="txt_num_tarjeta">N° de Tarjeta</label>
                        <input type="text" id="txt_num_tarjeta" name="txt_num_tarjeta" class="form-control" placeholder="N° de Tarjeta" maxlength="16">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="txt_num_cuenta">N° de Cuenta</label>
                        <input type="text" id="txt_num_cuenta" name="txt_num_cuenta" class="form-control" placeholder="N° de Cuenta" maxlength="20">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="txt_clave_interbancaria">Clabe Interbancaria</label>
                        <input type="text" id="txt_clave_interbancaria" name="txt_clave_interbancaria" class="form-control" placeholder="Clabe Interbancaria" maxlength="18">
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-start">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="txt_banco">Banco</label>
                        <input type="text" id="txt_banco" name="txt_banco" class="form-control text-uppercase" placeholder="Banco">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="txt_sueldo_mensual">Sueldo Mensual</label>
                        <input type="text" id="txt_sueldo_mensual" name="txt_sueldo_mensual" class="form-control" placeholder="Sueldo Mensual">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="txt_tipo_contrato">Tipo Contrato</label>
                        <select class="form-control" id="txt_tipo_contrato" name="txt_tipo_contrato">
                            <option>-- Elíge --</option>
                            <option>EVENTUAL</option>
                            <option>INDETERMINADO</option>
                            <option>PRUEBA</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>              
        <div class="card-footer">
            <button type="submit" class="btn btn-primary float-right">Guardar</button>
        </div>
        </form>
    </div>
</div>
@endsection
@push('scripts')
<script src="{{ asset('scripts/js/curp.js') }}"></script>
<script>
    $("#txt_codigo_postal").focusout(function() {
        cp = $('#txt_codigo_postal').val();
        if(cp.length == 5){
            $.ajax({
                type: "POST",
                url: "{{ url('/api/checkCp') }}",
                data: {
                    cp : cp
                },
                success:function(data){
                    $(".theSuburbs").empty().trigger('change');
                    if(data != 'Resultado no encontrado'){
                        cpError = 0;
                        $('#txt_codigo_postal').removeClass('is-invalid');
                        $('#txt_codigo_postal').addClass('is-valid');
                        $('#cpError').remove();
                        $('#txt_ciudad').val(data.Ciudad);
                        $('#txt_estado').val(data.Estado);
                        let theSuburbs = data.Asentamiento;
                        var data = {};

                        theSuburbs.forEach(function(theCurrentSuburb){
                            data.id = theCurrentSuburb;
                            data.text = theCurrentSuburb;
                            var newOption = new Option(data.text, data.id, false, false);
                            $('#txt_colonia').append(newOption).trigger('change');
                        });
                    }
                    else {
                        cpError = 1;
                        $('#txt_codigo_postal').addClass('is-invalid');
                        $('#cpError').remove();
                        $('#theCp').append('<span class="invalid-feedback" id="cpError" role="alert"><strong>No se ha encontrado ese C.P.</strong></span>');
                    }
                }
            });
        }
        else {
            $('#txt_codigo_postal').addClass('is-invalid');
            $('#cpError').remove();
            $('#theCp').append('<span class="invalid-feedback" id="cpError" role="alert"><strong>El código postal debe contener 5 números.</strong></span>');
        }
    });

    $('#txt_fecha_nac').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    $('#txt_fecha_alta').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })

    $(function(){
        $('#txt_fecha_nac').on('change', calcularEdad);
    });
    
    $('[data-mask]').inputmask()

    
    function calcularEdad(){
        var fecha=document.getElementById("txt_fecha_nac").value;
        var values=fecha.split("/");
        var dia = values[0];
        var mes = values[1];
        var ano = values[2];
        fecha=	dia+"/"+mes	+"/"+ano;
        var values=fecha.split("/");
		var dia = values[0];
        var mes = values[1];
        var ano = values[2];
        var fecha_hoy = new Date();
        var ahora_ano = fecha_hoy.getYear();
        var ahora_mes = fecha_hoy.getMonth();
        var ahora_dia = fecha_hoy.getDate();
 
        // realizamos el calculo
        var edad = (ahora_ano + 1900) - ano;
 
        if ( ahora_mes < (mes - 1)){
            edad--;
        }
        if (((mes - 1) == ahora_mes) && (ahora_dia < dia)){
            edad--;
        }
        if (edad > 1900){
            edad -= 1900;
        }
        $('#txt_edad').val(edad);
    }

    $("#txt_sueldo_mensual").maskMoney({
        decimal: ".",
        thousands: ","
    })

    $("#txt_puesto").select2({
        theme:"bootstrap4"
    });
    $("#txt_sucursal_ruta").select2({
        theme:"bootstrap4"
    });
    
</script>
@endpush