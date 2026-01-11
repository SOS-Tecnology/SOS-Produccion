<!-- resources/views/ordenes-pedido/show.blade.php -->
@extends('layouts.dashboard')

@section('title', 'Detalle de Orden de Pedido')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Detalle de Orden de Pedido #{{ $orden->documento }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('ordenes-pedido.edit', $orden->documento) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                        <a href="{{ route('ordenes-pedido.index') }}" class="btn btn-default btn-sm">
                            <i class="fas fa-arrow-left"></i> Volver
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Información del encabezado -->
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-bordered table-striped">
                                <tr>
                                    <th width="30%">Número de Documento</th>
                                    <td>{{ $orden->documento }}</td>
                                </tr>
                                <tr>
                                    <th>Cliente</th>
                                    <td>{{ $orden->cliente->nombrecli ?? '' }}</td>
                                </tr>
                                <tr>
                                    <th>Sucursal</th>
                                    <td>{{ $orden->sucursal->nombresuc ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Fecha del Pedido</th>
                                    <td>{{ $orden->fecha->format('d/m/Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Fecha de Entrega</th>
                                    <td>{{ $orden->fechent ? $orden->fechent->format('d/m/Y') : 'N/A' }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-bordered table-striped">
                                <tr>
                                    <th width="30%">Estado</th>
                                    <td>
                                        @switch($orden->estado)
                                            @case('P')
                                                <span class="badge badge-warning">Pendiente</span>
                                                @break
                                            @case('A')
                                                <span class="badge badge-info">Aprobada</span>
                                                @break
                                            @case('C')
                                                <span class="badge badge-success">Completada</span>
                                                @break
                                            @case('X')
                                                <span class="badge badge-danger">Cancelada</span>
                                                @break
                                            @default
                                                <span class="badge badge-secondary">{{ $orden->estado }}</span>
                                        @endswitch
                                    </td>
                                </tr>
                                <tr>
                                    <th>Subtotal</th>
                                    <td>{{ number_format($orden->valortotal - $orden->vriva, 2, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <th>IVA (16%)</th>
                                    <td>{{ number_format($orden->vriva, 2, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <th>Total</th>
                                    <td>{{ number_format($orden->valortotal, 2, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <th>Usuario</th>
                                    <td>{{ $orden->usuario }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    
                    @if($orden->comen)
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Comentarios</label>
                                    <p>{{ $orden->comen }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    <hr>
                    
                    <!-- Detalles de la orden -->
                    <div class="row">
                        <div class="col-12">
                            <h4>Productos de la Orden</h4>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Código</th>
                                            <th>Descripción</th>
                                            <th>Cantidad</th>
                                            <th>Valor Unitario</th>
                                            <th>Subtotal</th>
                                            <th>Color</th>
                                            <th>Talla</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($orden->detalles as $detalle)
                                            <tr>
                                                <td>{{ $detalle->codr }}</td>
                                                <td>{{ $detalle->descr }}</td>
                                                <td>{{ number_format($detalle->cantidad, 2, ',', '.') }}</td>
                                                <td>{{ number_format($detalle->valor, 2, ',', '.') }}</td>
                                                <td>{{ number_format($detalle->cantidad * $detalle->valor, 2, ',', '.') }}</td>
                                                <td>{{ $detalle->codcolor ?: 'N/A' }}</td>
                                                <td>{{ $detalle->codtalla ?: 'N/A' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-12 text-right">
                            <a href="{{ route('ordenes-pedido.edit', $orden->documento) }}" class="btn btn-warning">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                            <a href="{{ route('ordenes-pedido.index') }}" class="btn btn-default">
                                <i class="fas fa-arrow-left"></i> Volver
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection