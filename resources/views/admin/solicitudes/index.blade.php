@extends('layouts.AdminLTE.index')

@section('title', 'Solicitudes')
@section('header', 'Solicitudes')

@section('content')
    
    <div class="card">
        <div class="card-header with-border">
            <h3 class="card-title">Lista de Solicitudes</h3>
            <div class="card-tools pull-right">
                <a href="{{ route('admin.solicitud.create') }}"  type="button" class="btn btn-sm btn-primary" title="Agregar Solicitud"><li class="fas fa-plus"></li>&nbsp; Nueva Solicitud</a>
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
            </div>
            <table class="table table-striped projects">
                <thead>
                    <tr>
                        <th>ID solicitud</th>
                        <th>Cliente</th>
                        <th>Producto</th>
                        <th>Monto Solicitado</th>
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
                        <td>{{ $solicitud->producto()->first()->nombre }}</td>
                        <td>{{ number_format($solicitud->monto_solicitado,2,'.',',') }}</td>
                        <td>{{ date('d/m/Y', strtotime($solicitud->fecha_solicitud))}}</td> 
                        @if ($solicitud->estatus == 'Pendiente')
                            <td><small class="badge badge-warning"><i class="far fa-clock"></i> {{ $solicitud->estatus }}</small></td>
                            <td class="project-actions text-right">
                                <a class="btn btn-info btn-sm" href="{{ route('admin.solicitud.edit', [$solicitud->id]) }}"><i class="fas fa-pencil-alt"></i></a>
                            </td>
                        @elseif($solicitud->estatus == 'Proceso')
                            <td><small class="badge badge-info"><i class="fas fa-check"></i> {{ $solicitud->estatus }}</small></td>
                            <td class="project-actions text-right">
                                <a class="btn btn-info btn-sm" href="{{ route('admin.solicitud.edit', [$solicitud->id]) }}"><i class="fas fa-pencil-alt"></i></a>
                            </td>
                        @elseif($solicitud->estatus == 'Autorizado')
                            <td><small class="badge badge-success"><i class="fas fa-check"></i> {{ $solicitud->estatus }}</small></td>
                            <td class="project-actions text-right">
                                <a href="{{ route('admin.solicitudCredito', [$solicitud->id]) }}" target="_blank" class="btn btn-default btn-sm" title="Solicitud"><i class="fas fa-file-pdf"></i></a>
                                {{-- <a href="{{ route('admin.tablaPagos', [$solicitud->id]) }}" target="_blank" class="btn btn-default btn-sm" title="Tabla de Amortización"><i class="fas fa-file-pdf"></i></a> --}}
                            </td>
                        @elseif($solicitud->estatus == 'Rechazado')
                            <td><small class="badge badge-danger">{{ $solicitud->estatus }}</small></td>
                            <td class="project-actions text-right">
                                <button class="btn btn-info btn-sm"><i class="fas fa-ban"></i></button>
                            </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="float-right">{{ $solicitudes->appends(request()->query())->links()}}</div>
        </div>
    </div>
@endsection