@extends('layouts.AdminLTE.index')

@section('title', 'Cartera Vigente')
@section('header', 'Cartera Vigente')
@section('content')
    <div class="card">
        <div class="card-header with-border">
            <h3 class="card-title">Lista de Cartera Vigente</h3>
            <div class="form-group float-right">
                <a href="#" type="button" data-toggle="modal" data-target="#modalContabilidad" class="btn btn-sm btn-info" title="Generar Reporte"><i class="fas fa-file-excel"></i>&nbsp; Reporte Colocación</a>
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
            <div class="form-group float-right">
                <div class="d-flex">
                    <form action="{{ route('admin.cartera_vigente.index') }}">
                        @csrf
                        <input type="hidden" id="estatus" name="estatus" value="Pendiente">
                        <button type="submit" class="btn btn-app">
                            <span class="badge bg-warning">{{$statePendiente->count()}}</span>
                            <i class="fas fa-ban"></i> Pendiente
                        </button>
                    </form>
                    
                    <form action="{{ route('admin.cartera_vigente.index') }}">
                        @csrf
                        <input type="hidden" id="estatus" name="estatus" value="Desembolsado">
                        <button type="submit" class="btn btn-app">
                            <span class="badge bg-success">{{$stateDsembolsado->count()}}</span>
                            <i class="fas fa-check-circle"></i> Desembolsado
                        </button>
                    </form>
                </div>
            </div>
            <table class="table table-striped projects">
                <thead>
                    <tr>
                        <th>ID credito</th>
                        <th>Cliente</th>
                        <th>Producto</th>
                        <th>Monto Autorizado</th>
                        <th>Fecha Autorización</th>
                        <th>Estatus</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($creditos as $credito) 
                    <tr>
                        <td># {{ $credito->id }}</td>
                        <td>{{ $credito->solicitud->cliente->getFullName() }}</td>
                        <td>{{ $credito->solicitud->producto()->first()->nombre }}</td>
                        <td>{{ number_format($credito->monto_autorizado,2,'.',',') }}</td>
                        <td>{{ date('d/m/Y', strtotime($credito->detalleDesembolso->fecha_pago))}}</td>
                        @if ($credito->desembolso == 'Pendiente')
                            <td><small class="badge badge-warning">{{ $credito->desembolso }}&nbsp;&nbsp;<i class="far fa-clock"></i></small></td>
                            <td class="project-actions text-right">
                                <a class="btn btn-info btn-sm" href="{{ route('admin.desembolso.edit', [$credito->id]) }}"><i class="fas fa-comment-dollar"></i>&nbsp;Desembolsar</a>
                            </td>
                        @elseif($credito->desembolso == 'Desembolsado')
                            <td><small class="badge badge-success">{{ $credito->desembolso }}&nbsp;&nbsp;<i class="fas fa-check"></i></small></td>
                            <td class="project-actions text-right">
                                <button class="btn btn-info btn-sm"><i class="fas fa-ban"></i></button>
                            </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="float-right">{{ $creditos->appends(request()->query())->links()}}</div>
        </div>
    </div>
@endsection
<div class="modal fade" id="modalContabilidad" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none;" aria-modal="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ route('admin.colocacionClientes') }}" autocomplete="off" id="f_reporte_art" name="f_reporte_art" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Exportar Reporte Detalles</h5>
                    <button type="button" class="close" data-dismiss="modal" onclick="limpiaForm(f_reporte_art)" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="fecha_inicial">Fecha Inicial:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                </div>
                                <input type="date" id="fecha_inicial" name="fecha_inicial" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask value="{{ date('Y-m-d') }}">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label for="fecha_final">Fecha Final:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                </div>
                                <input type="date" id="fecha_final" name="fecha_final" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask value="{{ date('Y-m-d') }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="limpiaForm(f_reporte_art)">Cerrar</button>
                  <button type="submit" class="btn btn-primary">Exportar</button>
                  </div>
            </form>
        </div>
    </div>
</div>
