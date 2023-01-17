@extends('layouts.AdminLTE.index')
@section('title', 'Beneficiarios')
@section('header', 'Beneficiarios')
@section('content')
<div class="col-md-12">
    <div class="card ">
        <div class="card-header">
            <h4 class="card-title">
                Beneficiarios
            </h4>
        </div>
        <form method="POST" action="{{ route('admin.addBeneficiarios', $cliente) }}" autocomplete="off">
            @csrf
            <div class="card-body">
                <input type="hidden" id="idSolicitud" name="idSolicitud" value="{{$IDSol}}">
                <input type="hidden" id="idReferencia" name="idReferencia" value="0">
                <input type="hidden" id="idClienteRef" name="idClienteRef" value="{{$cliente}}">
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
                    <div class="col-sm-1">
                        <div class="form-group">
                            <label for="txt_porcentaje">Porcentaje</label>
                            <input type="number" id="txt_porcentaje" name="txt_porcentaje" class="form-control" required>
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
                                    <i class="fas fa-plus-circle"></i> &nbsp;Agregar Beneficiario
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
                                    <th>Porcentaje</th>
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
                                        <td>{{ $referencia->porcentaje}}</td>
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
@endsection
