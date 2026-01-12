<!-- resources/views/ordenes-pedido/edit.blade.php -->
@extends('layouts.dashboard')

@section('title', 'Editar Orden de Pedido')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Editar Orden de Pedido #{{ $orden->documento }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('ordenes-pedido.index') }}" class="btn btn-default btn-sm">
                            <i class="fas fa-arrow-left"></i> Volver
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="{{ route('ordenes-pedido.update', $orden->documento) }}" method="POST" id="formOrdenPedido">
                        @csrf
                        @method('PUT')

                        <!-- Encabezado de la orden -->
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="documento">Número de Documento</label>
                                    <input type="text" class="form-control" id="documento" name="documento" value="{{ $orden->documento }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="codcp">Cliente</label>
                                    <select class="form-control" id="codcp" name="codcp" required>
                                        <option value="">Seleccione un cliente</option>
                                        @foreach($clientes as $cliente)
                                        <option value="{{ $cliente->codcli }}" {{ $orden->codcp == $cliente->codcli ? 'selected' : '' }}>
                                            {{ $cliente->nombrecli }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="codsuc">Sucursal</label>
                                    <select class="form-control" id="codsuc" name="codsuc">
                                        <option value="">Seleccione primero un cliente</option>
                                        @foreach($sucursales as $sucursal)
                                        <option value="{{ $sucursal->codsuc }}" {{ $orden->codsuc == $sucursal->codsuc ? 'selected' : '' }}>
                                            {{ $sucursal->nombresuc }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="estado">Estado</label>
                                    <select class="form-control" id="estado" name="estado">
                                        <option value="P" {{ $orden->estado == 'P' ? 'selected' : '' }}>Pendiente</option>
                                        <option value="A" {{ $orden->estado == 'A' ? 'selected' : '' }}>Aprobada</option>
                                        <option value="C" {{ $orden->estado == 'C' ? 'selected' : '' }}>Completada</option>
                                        <option value="X" {{ $orden->estado == 'X' ? 'selected' : '' }}>Cancelada</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="fecha">Fecha del Pedido</label>
                                    <input type="date" class="form-control" id="fecha" name="fecha" value="{{ $orden->fecha->format('Y-m-d') }}" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="fechent">Fecha de Entrega</label>
                                    <input type="date" class="form-control" id="fechent" name="fechent" value="{{ $orden->fechent ? $orden->fechent->format('Y-m-d') : '' }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="comen">Comentarios</label>
                                    <textarea class="form-control" id="comen" name="comen" rows="1">{{ $orden->comen }}</textarea>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <!-- Productos de la orden -->
                        <div class="row">
                            <div class="col-12">
                                <h4>Productos de la Orden</h4>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="tablaProductos">
                                        <thead>
                                            <tr>
                                                <th>Producto</th>
                                                <th>Descripción</th>
                                                <th>Cantidad</th>
                                                <th>Valor Unitario</th>
                                                <th>Subtotal</th>
                                                <th>Color</th>
                                                <th>Talla</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($orden->detalles as $index => $detalle)
                                            <tr class="producto-row">
                                                <td>
                                                    <select class="form-control producto-select" name="productos[{{ $index }}][codr]" required>
                                                        <option value="">Seleccione un producto</option>
                                                        @foreach($productos as $producto)
                                                        <option value="{{ $producto->codr }}" {{ $detalle->codr == $producto->codr ? 'selected' : '' }}>
                                                            {{ $producto->codr }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control producto-descr" name="productos[{{ $index }}][descr]" value="{{ $detalle->descr }}" readonly>
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control producto-cantidad" name="productos[{{ $index }}][cantidad]" value="{{ $detalle->cantidad }}" step="0.01" min="0.01" required>
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control producto-valor" name="productos[{{ $index }}][valor]" value="{{ $detalle->valor }}" step="0.01" min="0" required>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control producto-subtotal" name="productos[{{ $index }}][subtotal]" value="{{ number_format($detalle->cantidad * $detalle->valor, 2) }}" readonly>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="productos[{{ $index }}][codcolor]" value="{{ $detalle->codcolor }}">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="productos[{{ $index }}][codtalla]" value="{{ $detalle->codtalla }}">
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-danger btn-sm remove-producto">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <button type="button" class="btn btn-success" id="addProducto">
                                    <i class="fas fa-plus"></i> Agregar Producto
                                </button>
                            </div>
                        </div>

                        <hr>

                        <!-- Resumen de totales -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="observaciones">Observaciones Adicionales</label>
                                    <textarea class="form-control" id="observaciones" name="observaciones" rows="3">{{ $orden->comenfac ?? '' }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="subtotal">Subtotal</label>
                                            <input type="text" class="form-control" id="subtotal" name="subtotal" value="{{ number_format($orden->valortotal - $orden->vriva, 2) }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="iva">IVA (16%)</label>
                                            <input type="text" class="form-control" id="iva" name="iva" value="{{ number_format($orden->vriva, 2) }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="total">Total</label>
                                            <input type="text" class="form-control" id="total" name="total" value="{{ number_format($orden->valortotal, 2) }}" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 text-right">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Actualizar Orden
                                </button>
                                <a href="{{ route('ordenes-pedido.index') }}" class="btn btn-default">
                                    <i class="fas fa-times"></i> Cancelar
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        let productoIndex = {
            {
                $orden - > detalles - > count()
            }
        };

        // Función para calcular el subtotal de un producto
        function calcularSubtotal(row) {
            const cantidad = parseFloat($(row).find('.producto-cantidad').val()) || 0;
            const valor = parseFloat($(row).find('.producto-valor').val()) || 0;
            const subtotal = cantidad * valor;
            $(row).find('.producto-subtotal').val(subtotal.toFixed(2));
            calcularTotales();
        }

        // Función para calcular los totales
        function calcularTotales() {
            let subtotal = 0;

            $('.producto-row').each(function() {
                const valorSubtotal = parseFloat($(this).find('.producto-subtotal').val()) || 0;
                subtotal += valorSubtotal;
            });

            const iva = subtotal * 0.16;
            const total = subtotal + iva;

            $('#subtotal').val(subtotal.toFixed(2));
            $('#iva').val(iva.toFixed(2));
            $('#total').val(total.toFixed(2));
        }

        // Evento para agregar un nuevo producto
        $('#addProducto').click(function() {
            const newRow = $('.producto-row:first').clone();

            // Actualizar los nombres y IDs de los campos
            newRow.find('select, input').each(function() {
                const name = $(this).attr('name').replace(/\[\d+\]/, `[${productoIndex}]`);
                $(this).attr('name', name);
                if ($(this).attr('type') !== 'hidden') {
                    $(this).val('');
                }
            });

            // Limpiar los valores
            newRow.find('.producto-descr').val('');
            newRow.find('.producto-subtotal').val('');

            // Agregar la nueva fila a la tabla
            $('#tablaProductos tbody').append(newRow);
            productoIndex++;
        });

        // Evento para eliminar una fila de producto
        $(document).on('click', '.remove-producto', function() {
            if ($('#tablaProductos tbody tr').length > 1) {
                $(this).closest('tr').remove();
                calcularTotales();
            } else {
                alert('Debe tener al menos un producto en la orden');
            }
        });

        // Evento para obtener la información del producto seleccionado
        $(document).on('change', '.producto-select', function() {
            const codr = $(this).val();
            const row = $(this).closest('tr');

            if (codr) {
                $.get(`/ordenes-pedido/producto/${codr}`, function(data) {
                    row.find('.producto-descr').val(data.descr);
                    row.find('.producto-valor').val(0);
                    calcularSubtotal(row);
                });
            } else {
                row.find('.producto-descr').val('');
                row.find('.producto-valor').val('');
                row.find('.producto-subtotal').val('');
                calcularTotales();
            }
        });

        // Eventos para calcular el subtotal cuando cambia la cantidad o el valor
        $(document).on('input', '.producto-cantidad, .producto-valor', function() {
            calcularSubtotal($(this).closest('tr'));
        });

        // Evento para obtener las sucursales del cliente seleccionado
        $('#codcp').change(function() {
            const codcli = $(this).val();
            const sucursalSelect = $('#codsuc');

            if (codcli) {
                $.get(`/ordenes-pedido/sucursales/${codcli}`, function(data) {
                    sucursalSelect.empty();

                    if (data.length > 0) {
                        sucursalSelect.append('<option value="">Seleccione una sucursal</option>');
                        data.forEach(function(sucursal) {
                            sucursalSelect.append(`<option value="${sucursal.codsuc}">${sucursal.nombresuc}</option>`);
                        });
                    } else {
                        sucursalSelect.append('<option value="">El cliente no tiene sucursales registradas</option>');
                    }
                });
            } else {
                sucursalSelect.empty();
                sucursalSelect.append('<option value="">Seleccione primero un cliente</option>');
            }
        });
    });
</script>
@endpush