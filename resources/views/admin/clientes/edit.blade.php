@extends('layouts.AdminLTE.index')
@section('title', 'Clientes')
@section('header', 'Clientes')
@section('content')
<div class="col-md-12">
    <div class="card">
        @if(Session::has('mensaje'))
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            {{Session::get('mensaje')}}
            </div>  
        @endif 
        
        @if(Session::has('mensaje') == 'Referencia agregada' || Session::has('mensaje') == 'Registro exitoso')
            @php
                $activeC = '';
                $activeR = 'active';
            @endphp
        @else
            @php
                $activeC = 'active';
                $activeR = '';
            @endphp
        @endif 
        <div class="card-header">
            <ul class="nav nav-pills">
                <li class="nav-item"><a class="nav-link {{$activeC}}" href="#navCliente" data-toggle="tab">Nuevo Cliente</a></li>
                <li class="nav-item"><a class="nav-link {{$activeR}}" href="#navReferencia" data-toggle="tab">Referencias</a></li>
            </ul>
        </div>
      
        <div class="tab-content">
            <div class="{{$activeC}} tab-pane" id="navCliente">
                <form method="POST" action="{{action('ClienteAdminController@update', $cliente->id)}}" autocomplete="off">
                @method('PUT')	
                @csrf
                <div class="card-body">
                    <div class="d-flex justify-content-start">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="txt_nombre">Nombre</label>
                                <input type="text" id="txt_nombre" name="txt_nombre" class="form-control text-uppercase" placeholder="Nombre(s)" value="{{ $cliente->nombre}}">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="txt_apellido_paterno">Apellido Paterno</label>
                                <input type="text" id="txt_apellido_paterno" name="txt_apellido_paterno" class="form-control text-uppercase" placeholder="Apellido Paterno" value="{{ $cliente->apellido_paterno}}">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="txt_apellido_materno">Apellido Materno</label>
                                <input type="text" id="txt_apellido_materno" name="txt_apellido_materno" class="form-control text-uppercase" placeholder="Apellido Materno" value="{{ $cliente->apellido_materno}}">
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-start">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="txt_fecha_nac">Fecha de Nacimiento</label>
                                <input type="text" id="txt_fecha_nac" name="txt_fecha_nac" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" placeholder="dd/mm/yyyy" value="{{ $cliente->fecha_nacimiento}}">
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="position-relative form-group" id="theAge">
                                <label for="txt_edad" class="">Edad</label>
                                <input name="txt_edad" id="txt_edad" type="text" value="{{ $cliente->edad}}" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="txt_genero">Género</label>
                                <select class="form-control" id="txt_genero" name="txt_genero">
                                    <option {{ $cliente->genero == 'M' ? 'selected' : ''}} value="M">Masculino</option>
                                    <option {{ $cliente->genero == 'F' ? 'selected' : ''}} value="F">Femenino</option>
                                    <option {{ $cliente->genero == 'x' ? 'selected' : ''}} value="x">Indistinto</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-start">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="txt_ciudad_nacimiento">Ciudad de Nacimiento</label>
                                <input type="text" id="txt_ciudad_nacimiento" name="txt_ciudad_nacimiento" class="form-control text-uppercase" placeholder="Ciudad de Nacimiento" value="{{ $cliente->ciudad_nacimiento}}">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="txt_estado_nacimiento">Estado de Nacimiento</label>
                                <select type="select" id="txt_estado_nacimiento" name="txt_estado_nacimiento" class="form-control @error('state') is-invalid @enderror" required onchange="btGenCurp(this.form, '3');">
                                    <option value="">Seleccionar</option>
                                    @foreach($estados_nac as $estado)
                                        <option {{ old('txt_estado_nacimiento') == $estado->clave ? 'selected' : ($opcionEstado != "N/A" ? ($opcionEstado == $estado->clave ? 'selected' : '')  : '') }} value="{{$estado->clave}}">{{$estado->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="txt_nacionalidad">Nacionalidad</label>
                                <input type="text" id="txt_nacionalidad" name="txt_nacionalidad" class="form-control text-uppercase" placeholder="Nacionalidad" value="{{ $cliente->nacionalidad}}">
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-start">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="txt_rfc">RFC</label>
                                <input type="text" id="txt_rfc" name="txt_rfc" class="form-control text-uppercase" placeholder="RFC" value="{{ $cliente->rfc}}" maxlength="13">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="txt_curp">CURP</label>
                                <input type="text" id="txt_curp" name="txt_curp" class="form-control text-uppercase" placeholder="CURP" value="{{ $cliente->curp}}" maxlength="18">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="txt_pasaporte">Pasaporte</label>
                                <input type="text" id="txt_pasaporte" name="txt_pasaporte" class="form-control text-uppercase" placeholder="Pasaporte" value="{{ $cliente->pasaporte}}"  maxlength="15">
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-start">
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="txt_tipo_vivienda">Tipo Vivienda</label>
                                <select class="form-control" id="txt_tipo_vivienda" name="txt_tipo_vivienda">
                                    <option {{ $cliente->tipo_vivienda == 'PROPIA' ? 'selected' : ''}} value="PROPIA">Propia</option>
                                    <option {{ $cliente->tipo_vivienda == 'RENTADA' ? 'selected' : ''}} value="RENTADA">Rentada</option>
                                    <option {{ $cliente->tipo_vivienda == 'FAMILIAR' ? 'selected' : ''}} value="FAMILIAR">Familiar</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="txt_direccion">Dirección</label>
                                <input type="text" id="txt_direccion" name="txt_direccion" class="form-control text-uppercase" placeholder="Dirección" value="{{ $cliente->direccion}}">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="txt_residencia">Años de Residencia</label>
                                <input type="text" id="txt_residencia" name="txt_residencia" class="form-control text-uppercase" placeholder="Años de Residencia" value="{{ $cliente->anios_residencia}}">
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-start">
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label for="txt_vialidad">Vialidad</label>
                                <select class="form-control" id="txt_vialidad" name="txt_vialidad">
                                    <option {{ $cliente->tipo_vialidad == 'Ampliacion' ? 'selected' : ''}} value="Ampliacion">Ampliación</option>
                                    <option {{ $cliente->tipo_vialidad == 'Andador' ? 'selected' : ''}} value="Andador">Andador</option>
                                    <option {{ $cliente->tipo_vialidad == 'Avenida' ? 'selected' : ''}} value="Avenida">Avenida</option>
                                    <option {{ $cliente->tipo_vialidad == 'Boulevard' ? 'selected' : ''}} value="Boulevard">Boulevard</option>
                                    <option {{ $cliente->tipo_vialidad == 'Calle' ? 'selected' : ''}} value="Calle">Calle</option>
                                    <option {{ $cliente->tipo_vialidad == 'Callejon' ? 'selected' : ''}} value="Callejon">Callejon</option>
                                    <option {{ $cliente->tipo_vialidad == 'Calzada' ? 'selected' : ''}} value="Calzada">Calzada</option>
                                    <option {{ $cliente->tipo_vialidad == 'Cerrada' ? 'selected' : ''}} value="Cerrada">Cerrada</option>
                                    <option {{ $cliente->tipo_vialidad == 'Circuito' ? 'selected' : ''}} value="Circuito">Circuito</option>
                                    <option {{ $cliente->tipo_vialidad == 'Circumbalacion' ? 'selected' : ''}} value="Circumbalacion">Circumbalación</option>
                                    <option {{ $cliente->tipo_vialidad == 'Continuacion' ? 'selected' : ''}} value="Continuacion">Continuación</option>
                                    <option {{ $cliente->tipo_vialidad == 'Corredor' ? 'selected' : ''}} value="Corredor">Corredor</option>
                                    <option {{ $cliente->tipo_vialidad == 'Diagonol' ? 'selected' : ''}} value="Diagonol">Diagonol</option>
                                    <option {{ $cliente->tipo_vialidad == 'Eje Vial' ? 'selected' : ''}} value="Eje Vial">Eje Vial</option>
                                    <option {{ $cliente->tipo_vialidad == 'Pasaje' ? 'selected' : ''}} value="Pasaje">Pasaje</option>
                                    <option {{ $cliente->tipo_vialidad == 'Peatonal' ? 'selected' : ''}} value="Peatonal">Peatonal</option>
                                    <option {{ $cliente->tipo_vialidad == 'Periferico' ? 'selected' : ''}} value="Periferico">Periferico</option>
                                    <option {{ $cliente->tipo_vialidad == 'Privada' ? 'selected' : ''}} value="Privada">Privada</option>
                                    <option {{ $cliente->tipo_vialidad == 'Prolongacion' ? 'selected' : ''}} value="Prolongacion">Prolongación</option>
                                    <option {{ $cliente->tipo_vialidad == 'Retorno' ? 'selected' : ''}} value="Retorno">Retorno</option>
                                    <option {{ $cliente->tipo_vialidad == 'Viaducto' ? 'selected' : ''}} value="Viaducto">Viaducto</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-7">
                            <div class="form-group">
                                <label for="txt_entre_calles">Entre calles</label>
                                <input type="text" id="txt_entre_calles" name="txt_entre_calles" class="form-control text-uppercase" placeholder="Entre calles" value="{{ $cliente->entre_calles}}">
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-start">
                        <div class="col-sm-8">
                            <div class="form-group">
                                <label for="txt_referencia">Referencia</label>
                                <input type="text" id="txt_referencia" name="txt_referencia" class="form-control text-uppercase" placeholder="Referencia" value="{{ $cliente->referencia}}">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group" id="theCp">
                                <label for="txt_codigo_postal">Codigo Postal</label>
                                <input type="text" id="txt_codigo_postal" name="txt_codigo_postal" class="form-control" placeholder="Codigo Postal" value="{{ $cliente->cp}}">
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-start">
                        <div class="col-sm-4">
                            <div class="form-group" id="theSuburb">
                                <label for="txt_colonia">Colonia</label>
                                <select name="txt_colonia" id="txt_colonia" class="form-control text-uppercase theSuburbs">
                                    <option value="{{ $cliente->colonia }}">{{ $cliente->colonia }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group" id="theCity">
                                <label for="txt_ciudad">Ciudad</label>
                                <input type="text" id="txt_ciudad" name="txt_ciudad" class="form-control" placeholder="Ciudad" value="{{ $cliente->ciudad}}">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group" id="theState">
                                <label for="txt_estado">Estado</label>
                                <input type="text" id="txt_estado" name="txt_estado" class="form-control" placeholder="Estado" value="{{ $cliente->estado}}">
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-start">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="txt_celular">Celular</label>
                                <input type="text" id="txt_celular" name="txt_celular" class="form-control" placeholder="(999) 999-9999" data-inputmask='"mask": "(999) 999-9999"' data-mask value="{{ $cliente->celular}}">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="txt_fecha_alta">Fecha de Alta</label>
                                <input type="text" id="txt_fecha_alta" name="txt_fecha_alta" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" placeholder="dd/mm/yyyy" value="{{ $cliente->fecha_alta}}">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="txt_escolaridad">Escolaridad</label>
                                <select class="form-control" id="txt_escolaridad" name="txt_escolaridad">
                                    <option {{ $cliente->escolaridad == 'NINGUNA' ? 'selected' : ''}} value="NINGUNA">Ninguna</option>
                                    <option {{ $cliente->escolaridad == 'LEER Y ESCRIBIR' ? 'selected' : ''}} value="LEER Y ESCRIBIR">Leer y Escribir</option>
                                    <option {{ $cliente->escolaridad == 'PREESCOLAR' ? 'selected' : ''}} value="PREESCOLAR">Preescolar</option>
                                    <option {{ $cliente->escolaridad == 'PRIMARIA' ? 'selected' : ''}} value="PRIMARIA">Primaria</option>
                                    <option {{ $cliente->escolaridad == 'SECUNDARIA' ? 'selected' : ''}} value="SECUNDARIA">Secundaria</option>
                                    <option {{ $cliente->escolaridad == 'PREPARATORIA' ? 'selected' : ''}} value="SOCIO FUNDADOR">Preparatoria</option>
                                    <option {{ $cliente->escolaridad == 'LICENCIATURA' ? 'selected' : ''}} value="LICENCIATURA">Licenciatura</option>
                                    <option {{ $cliente->escolaridad == 'MAESTRIA' ? 'selected' : ''}} value="MAESTRIA">Maestria</option>
                                    <option {{ $cliente->escolaridad == 'DOCTORADO' ? 'selected' : ''}} value="DOCTORADO">Doctorado</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-start">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="txt_profesion">Profesión</label>
                                <input type="text" id="txt_profesion" name="txt_profesion" class="form-control text-uppercase" placeholder="Profesión" value="{{ $cliente->profesion}}">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="txt_religion">Religión</label>
                                <select class="form-control" id="txt_religion" name="txt_religion">
                                    <option {{ $cliente->religion == 'SIN RELIGION' ? 'selected' : ''}} value="SIN RELIGION">Sin Religion</option>
                                    <option {{ $cliente->religion == 'CRISTIANISMO' ? 'selected' : ''}} value="CRISTIANISMO">Cristianismo</option>
                                    <option {{ $cliente->religion == 'BUDISMO' ? 'selected' : ''}} value="BUDISMO">Budismo</option>
                                    <option {{ $cliente->religion == 'HINDUISMO' ? 'selected' : ''}} value="HINDUISMO">Hinduismo</option>
                                    <option {{ $cliente->religion == 'TESTIGO DE JEHOVA' ? 'selected' : ''}} value="TESTIGO DE JEHOVA">Testigo de Jehova</option>
                                    <option {{ $cliente->religion == 'PRESBISTERIANA' ? 'selected' : ''}} value="PRESBISTERIANA">Presbiteriana</option>
                                    <option {{ $cliente->religion == 'CATOLICA' ? 'selected' : ''}} value="CATOLICA">Catolica</option>
                                    <option {{ $cliente->religion == 'PROTESTANTE' ? 'selected' : ''}} value="PROTESTANTE">Protestante</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="txt_estado_civil">Estado Civil</label>
                                <select class="form-control" id="txt_estado_civil" name="txt_estado_civil">
                                    <option {{ $cliente->estado_civil == 'SOLTERO(A)' ? 'selected' : ''}} value="SOLTERO(A)">Soltera</option>
                                    <option {{ $cliente->estado_civil == 'CASADO(A)' ? 'selected' : ''}} value="CASADO(A)">Casada</option>
                                    <option {{ $cliente->estado_civil == 'UNION LIBRE' ? 'selected' : ''}} value="UNION LIBRE">Union Libre</option>
                                    <option {{ $cliente->estado_civil == 'DIVORCIADO(A)' ? 'selected' : ''}} value="DIVORCIADO(A)">Divorciada</option>
                                    <option {{ $cliente->estado_civil == 'VIUDO(A)' ? 'selected' : ''}} value="VIUDO(A)">Viuda</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-start">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="txt_clave_elector">Clave de Elector</label>
                                <input type="text" id="txt_clave_elector" name="txt_clave_elector" class="form-control text-uppercase" placeholder="Clave de Elector" value="{{ $cliente->clave_elector}}"  maxlength="18" onchange="validarClaveElector()">
                            </div>
                            <small id="msjValidacion" class="text-danger"></small>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="txt_vencimiento_ine">Año de vencimiento</label>
                                <input type="text" id="txt_vencimiento_ine" name="txt_vencimiento_ine" class="form-control" placeholder="aaaa" value="{{ $cliente->anio_vencimiento_ine}}" maxlength="4">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="txt_folio_ine">Folio INE</label>
                                <input type="text" id="txt_folio_ine" name="txt_folio_ine" class="form-control" placeholder="Folio INE" value="{{ $cliente->folio_ine}}" maxlength="20">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="txt_ocr">OCR</label>
                                <input type="text" id="txt_ocr" name="txt_ocr" class="form-control" placeholder="OCR" value="{{ $cliente->ocr}}"  maxlength="13">
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-start">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="txt_num_tarjeta">N° de Tarjeta</label>
                                <input type="text" id="txt_num_tarjeta" name="txt_num_tarjeta" class="form-control" placeholder="N° de Tarjeta" value="{{ $cliente->numero_tarjeta}}" maxlength="16">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="txt_num_cuenta">N° de Cuenta</label>
                                <input type="text" id="txt_num_cuenta" name="txt_num_cuenta" class="form-control" placeholder="N° de Cuenta" value="{{ $cliente->numero_cuenta}}" maxlength="20">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="txt_clave_interbancaria">Clabe Interbancaria</label>
                                <input type="text" id="txt_clave_interbancaria" name="txt_clave_interbancaria" class="form-control" placeholder="Clabe Interbancaria" value="{{ $cliente->clave_interbancaria}}" maxlength="18">
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-start">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="txt_banco">Banco</label>
                                <input type="text" id="txt_banco" name="txt_banco" class="form-control text-uppercase" placeholder="Banco" value="{{ $cliente->banco}}">
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label for="txt_cuenta" class="">Cuenta Contable del Producto</label>
                                <select type="select" id="txt_cuenta" name="txt_cuenta" class="form-control select2 ">
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
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="txt_tipo_cliente">Tipo de Cliente</label>
                                <select class="form-control" id="txt_tipo_cliente" name="txt_tipo_cliente">
                                    <option {{ $cliente->tipo_cliente == 'NUEVO' ? 'selected' : ''}} value="NUEVO">Nuevo</option>
                                    <option {{ $cliente->tipo_cliente == 'REINGRESO' ? 'selected' : ''}} value="REINGRESO">Reingreso</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-start">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="txt_nombre_asociado" class="">Nombre Asociado</label>
                                <select type="select" id="txt_nombre_asociado" name="txt_nombre_asociado" class="form-control select2 ">
                                    <option value="">Seleccionar</option>
                                    @foreach($asociados as $asociado)
                                        <option {{ old('txt_nombre_asociado') == $asociado->id ? 'selected' : ($personAsociado != "N/A" ? ($personAsociado == $asociado->id ? 'selected' : '')  : '') }} value="{{$asociado->id}}">{{$asociado->getFullname()}}</option>
                                    @endforeach
                                </select>
                                @error('userType')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="txt_nombre_aval" class="">Nombre Aval</label>
                                <select type="select" id="txt_nombre_aval" name="txt_nombre_aval" class="form-control select2 ">
                                    <option value="">Seleccionar</option>
                                    @foreach($avales as $aval)
                                        <option {{ old('txt_nombre_aval') == $aval->id ? 'selected' : ($personAval != "N/A" ? ($personAval == $aval->id ? 'selected' : '')  : '') }} value="{{$aval->id}}">{{$aval->getFullname()}}</option>
                                    @endforeach
                                </select>
                                @error('userType')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>              
                <div class="card-footer">
                    <div class="col-12">
                        <a type="button" href="{{ route('admin.cliente.index') }}" class="btn btn-danger float-right">Cerrar</a>
                        <button type="submit" class="btn btn-primary float-right" style="margin-right: 5px;">Guardar</button>
                    </div>
                </div>
                </form>
            </div>
            <div class="{{$activeR}} tab-pane" id="navReferencia">
                <form method="POST" action="{{ route('admin.addreferencias', $cliente->id) }}" autocomplete="off">
                @csrf
                <div class="card-body">
                    <input type="hidden" id="idReferencia" name="idReferencia" value="0">
                    <input type="hidden" id="idClienteRef" name="idClienteRef" value="0">
                    <div class="d-flex justify-content-start">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="txt_nombre_ref">Nombre</label>
                                <input type="text" id="txt_nombre_ref" name="txt_nombre_ref" class="form-control text-uppercase" placeholder="Nombre(s)">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="txt_apellido_paterno_ref">Apellido Paterno</label>
                                <input type="text" id="txt_apellido_paterno_ref" name="txt_apellido_paterno_ref" class="form-control text-uppercase" placeholder="Apellido Paterno">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="txt_apellido_materno_ref">Apellido Materno</label>
                                <input type="text" id="txt_apellido_materno_ref" name="txt_apellido_materno_ref" class="form-control text-uppercase" placeholder="Apellido Materno">
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-start">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="txt_parentesco_ref">Parentesco</label>
                                <select class="form-control" id="txt_parentesco_ref" name="txt_parentesco_ref">
                                    <option>-- Elíge --</option>
                                    <option>HIJO(A)</option>
                                    <option>PADRE</option>
                                    <option>MADRE</option>
                                    <option>ESPOSO(A)</option>
                                    <option>HERMANO(A)</option>
                                    <option>ABUELO(A)</option>
                                    <option>NIETO(A)</option>
                                    <option>SOBRINO(A)</option>
                                    <option>YERNO</option>
                                    <option>NUERA</option>
                                    <option>CUÑADO(A)</option>
                                    <option>TIO(A)</option>
                                    <option>PRIMO(A)</option>
                                    <option>CONOCIDO(A)</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="txt_celular_ref">Celular</label>
                                <input type="text" id="txt_celular_ref" name="txt_celular_ref" class="form-control" placeholder="(999) 999-9999" data-inputmask='"mask": "(999) 999-9999"' data-mask>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="txt_tipo_ref">Tipo</label>
                                <select class="form-control" id="txt_tipo_ref" name="txt_tipo_ref">
                                    <option>FAMILIAR</option>
                                    <option>COMERCIAL</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-start">
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label for="txt_direccion_ref">Dirección</label>
                                <input type="text" id="txt_direccion_ref" name="txt_direccion_ref" class="form-control text-uppercase" placeholder="Dirección">
                            </div>
                        </div>
                        <div class="col-sm-7">
                            <div class="form-group">
                                <label for="txt_entre_calles_ref">Entre calles</label>
                                <input type="text" id="txt_entre_calles_ref" name="txt_entre_calles_ref" class="form-control text-uppercase" placeholder="Entre calles">
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-start">
                        <div class="col-sm-3">
                            <div class="form-group" id="theCpRef">
                                <label for="txt_codigo_postal_ref">Codigo Postal</label>
                                <input type="text" id="txt_codigo_postal_ref" name="txt_codigo_postal_ref" class="form-control" placeholder="Codigo Postal">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group" id="theSuburbRef">
                                <label for="txt_colonia_ref">Colonia</label>
                                <select name="txt_colonia_ref" id="txt_colonia_ref" class="form-control text-uppercase theSuburbs" required>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group" id="theCityRef">
                                <label for="txt_ciudad_ref">Ciudad</label>
                                <input type="text" id="txt_ciudad_ref" name="txt_ciudad_ref" class="form-control" placeholder="Ciudad">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group" id="theStateRef">
                                <label for="txt_estado_ref">Estado</label>
                                <input type="text" id="txt_estado_ref" name="txt_estado_ref" class="form-control" placeholder="Estado">
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-start">
                        <div class="col-sm-8">
                            <div class="form-group">
                                <label for="txt_referencia_ref">Referencias</label>
                                <input type="text" id="txt_referencia_ref" name="txt_referencia_ref" class="form-control text-uppercase" placeholder="Referencias">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for=""></label>
                                <div style="position: absolute;top: 45%;">
                                    <button type="submit" class="btn btn-primary btn-sm" title="Guardar">
                                        <i class="fas fa-plus-circle"></i> &nbsp;Agregar Referencia
                                    </button>
                                </div>
                                   
                            </div>    
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-12 table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Nombre</th>
                                        <th>Parentesco</th>
                                        <th>Tipo</th>
                                        <th style="width: 40px">Acción</th>
                                    </tr>
                                </thead>
                                @if (!empty($referencias))
                                    <tbody>
                                            @php
                                                $cont = 0;
                                            @endphp
                                        @foreach($referencias as $referencia)
                                            @php
                                                $cont ++;
                                            @endphp
                                        <tr>
                                            <td>{{ $cont }}.</td>
                                            <td>{{ $referencia->getFullName() }}</td>
                                            <td>{{ $referencia->parentesco}}</td>
                                            <td>{{ $referencia->tipo_referencia}}</td>
                                            <td><a href="#" class="badge bg-info" title="Click para editar" onclick="cargarReferencia('{{ $referencia->id }}')">Editar</a></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                @endif
                               
                            </table>
                        </div>
                        <!-- /.col -->
                      </div>
                </div> 
                <div class="card-footer">
                    <div class="col-12">
                        <a type="button" href="{{ route('admin.cliente.index') }}" class="btn btn-danger float-right">Cerrar</a>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src="{{ asset('scripts/js/curp.js') }}"></script>
<script>

     $.ajaxSetup({
        headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
    });


    $("#txt_nombre_asociado").select2({
        theme:"bootstrap4"
    });

    $("#txt_nombre_aval").select2({
        theme:"bootstrap4"
    });
    
    $("#txt_cuenta").select2({
        theme:"bootstrap4"
    });

    $("#txt_estado_nacimiento").select2({
        theme:"bootstrap4"
    });

    $('#txt_fecha_nac').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    $('#txt_fecha_alta').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })

    $('[data-mask]').inputmask()

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
    
    $(function(){
        $('#txt_fecha_nac').on('change', calcularEdad);
    });
        
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

    function validarClaveElector(){
        var claveElector = document.getElementById("txt_clave_elector").value;
        $.ajax({
            type: "get",
            url: "{{ asset('admin/clientes/validarClaveElector') }}/" + claveElector,
            type: 'get',
            success: function(data){
                console.log(data);
                if(data.clientExiste){
                    $('#msjValidacion').html('<i class="fa fa-bell fa-lg faa-ring animated"></i>'+' '+' ESTE CLIENTE YA EXISTE!')
                    $("#botonera").hide('slow')
                }else{
                    $('#msjValidacion').html('')
                    $("#botonera").show('slow')
                }
               
            },
        })
        return false;
    }

    $("#txt_codigo_postal_ref").focusout(function() {
        cp = $('#txt_codigo_postal_ref').val();
        if(cp.length == 5){
            $.ajax({
                type: "POST",
                url: "{{ url('/api/checkCp') }}",
                data: {
                    cp : cp
                },
                success:function(data){
                    $(".theSuburbsRef").empty().trigger('change');
                    if(data != 'Resultado no encontrado'){
                        cpErrorRef = 0;
                        $('#txt_codigo_postal_ref').removeClass('is-invalid');
                        $('#txt_codigo_postal_ref').addClass('is-valid');
                        $('#cpErrorRef').remove();
                        $('#txt_ciudad_ref').val(data.Ciudad);
                        $('#txt_estado_ref').val(data.Estado);
                        let theSuburbsRef = data.Asentamiento;
                        var data = {};

                        theSuburbsRef.forEach(function(theCurrentSuburbRef){
                            data.id = theCurrentSuburbRef;
                            data.text = theCurrentSuburbRef;
                            var newOption = new Option(data.text, data.id, false, false);
                            $('#txt_colonia_ref').append(newOption).trigger('change');
                        });
                    }
                    else {
                        cpErrorRef = 1;
                        $('#txt_codigo_postal_ref').addClass('is-invalid');
                        $('#cpErrorRef').remove();
                        $('#theCpRef').append('<span class="invalid-feedback" id="cpErrorRef" role="alert"><strong>No se ha encontrado ese C.P.</strong></span>');
                    }
                }
            });
        }
        else {
            $('#txt_codigo_postal_ref').addClass('is-invalid');
            $('#cpErrorRef').remove();
            $('#theCpRef').append('<span class="invalid-feedback" id="cpErrorRef" role="alert"><strong>El código postal debe contener 5 números.</strong></span>');
        }
    });

    function cargarReferencia(idRef){
        $.ajax({
            url: "{{ asset('admin/clientes/datosReferencia') }}/" + idRef,
            type: 'get',
            cache: false,
            beforeSend(){

            },
            success: function(data){
                console.log(data);
                $('#idReferencia').val(data.referencia.id);
                $('#idClienteRef').val(data.referencia.clientes_id);
                $('#txt_nombre_ref').val(data.referencia.nombre);
                $('#txt_apellido_paterno_ref').val(data.referencia.apellido_paterno);
                $('#txt_apellido_materno_ref').val(data.referencia.apellido_materno);
                $('#txt_parentesco_ref').val(data.referencia.parentesco);
                $('#txt_celular_ref').val(data.referencia.telefono);
                $('#txt_tipo_ref').val(data.referencia.tipo_referencia);
                $('#txt_direccion_ref').val(data.referencia.direccion);
                $('#txt_entre_calles_ref').val(data.referencia.entre_calles);
                $('#txt_codigo_postal_ref').val(data.referencia.cp);
                $('#txt_colonia_ref').append($('<option>').val(data.referencia.colonia).text(data.referencia.colonia));
                $('#txt_ciudad_ref').val(data.referencia.ciudad);
                $('#txt_estado_ref').val(data.referencia.estado);
                $('#txt_referencia_ref').val(data.referencia.referencia);

            }
        });
    }
</script>
@endpush