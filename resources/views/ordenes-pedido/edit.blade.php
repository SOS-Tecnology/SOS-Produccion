@extends('layouts.dashboard')

@section('title', 'Editar Pedido')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="md:flex md:items-center md:justify-between">
            <div class="flex-1 min-w-0">
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">Editar Pedido #{{ $orden->documento }}</h2>
            </div>
            <div class="mt-4 flex md:mt-0 md:ml-4">
                <a href="{{ route('ordenes-pedido.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Volver al listado
                </a>
            </div>
        </div>
    </div>

    <div class="max-w-screen-2xl mx-auto mt-8 sm:px-6 lg:px-8">
        <div class="bg-white shadow overflow-hidden sm:rounded-md">
            <form action="{{ route('ordenes-pedido.update', $orden->documento) }}" method="POST" autocomplete="off">
                @csrf
                @method('PUT')
                <!-- Encabezado -->
                <div class="px-4 py-5 sm:px-6 space-y-6 bg-slate-50 rounded-t-lg">
                    @if ($errors->any())
                    <div class="rounded-md bg-red-50 p-4">
                        <!-- ... código de errores ... -->
                    @endif
                    <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                        <div class="sm:col-span-2">
                            <label for="documento" class="block text-sm font-medium text-gray-700">N.° de documento</label>
                            <div class="mt-1">
                                <input type="text" name="documento" id="documento" value="{{ $orden->documento }}" class="shadow-sm bg-gray-100 block w-full sm:text-sm border-gray-300 rounded-md" readonly>
                            </div>
                        </div>
                        <div class="sm:col-span-2">
                            <label for="codcp" class="block text-sm font-medium text-gray-700">Cliente</label>
                            <div class="mt-1">
                                <select id="codcp" name="codcp" class="js-example-basic-single shadow-sm block w-full sm:text-sm border-gray-300 rounded-md" required>
                                    <option value="">Seleccionar...</option>
                                    @foreach($clientes as $cliente)
                                    <option value="{{ $cliente->codcli }}" {{ $orden->codcp == $cliente->codcli ? 'selected' : '' }}>{{ $cliente->nombrecli }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!-- ... otros campos del encabezado (sucursal, fechas, estado, comentarios) ... -->
                    </div>
                </div>

                <!-- Productos -->
                <div class="px-4 sm:px-6 bg-white border-t border-gray-200">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 my-3">Productos</h3>
                </div>
                <div class="px-4 sm:px-6 bg-white pb-4">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/3">Producto</th>
                                    <th class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24">Color</th>
                                    <th class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24">Talla</th>
                                    <th class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-20">Cantidad</th>
                                    <th class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-28">V. Unidad.</th>
                                    <th class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-28">Subtotal</th>
                                    <th class="px-2 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-16">Acc.</th>
                                </tr>
                            </thead>
                            <tbody id="productos-tbody">
                                @foreach($orden->detalles as $index => $producto)
                                <tr class="producto-row item-group">
                                    <td class="px-2 py-2 align-top">
                                        <select class="producto-select js-example-basic-single shadow-sm block w-full text-sm border-gray-300 rounded-md" name="productos[{{ $index }}][codr]" required>
                                            <option value="">Seleccionar...</option>
                                            @foreach($productos as $p)
                                            <option value="{{ $p->codr }}" {{ $producto->codr == $p->codr ? 'selected' : '' }}>{{ $p->codr }} - {{ $p->descr }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="px-2 py-2 align-top">
                                        <select class="shadow-sm block w-full text-sm border-gray-300 rounded-md" name="productos[{{ $index }}][codcolor]">
                                            <option value="">Seleccionar...</option>
                                            @foreach($colores as $color)
                                            <option value="{{ $color['codcolor'] }}" {{ $producto->codcolor == $color['codcolor'] ? 'selected' : '' }}>{{ $color['nombrecolor'] }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <!-- ... resto de los campos del producto ... -->
                                </tr>
                                <tr>
                                    <td colspan="6" class="px-2 py-1 align-top">
                                        <textarea name="productos[{{ $index }}][comencpo]" rows="1" class="shadow-sm block w-full text-sm border-gray-300 rounded-md" placeholder="Comentarios del ítem...">{{ $producto->comencpo }}</textarea>
                                    </td>
                                    <td class="px-2 py-1 text-right align-top">
                                        <button type="button" class="eliminar-producto text-red-600 hover:text-red-900">
                                            <!-- Icono de eliminar -->
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        <button type="button" id="addProducto" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            + Agregar Producto
                        </button>
                    </div>
                </div>

                <!-- La plantilla oculta es la misma que en create.blade.php -->
                <template id="producto-template">...</template>

                <!-- Botones -->
                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6 border-t border-gray-200">
                    <button type="submit" class="bg-indigo-600 border border-transparent rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Actualizar orden
                    </button>
                    <a href="{{ route('ordenes-pedido.index') }}" class="ml-3 bg-white border border-gray-300 rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- El mismo bloque de scripts que en create.blade.php -->
<script>
    window.tallasData = @json($tallas);
    window.coloresData = @json($colores);
</script>
<script>
    // --- CAMBIO CLAVE AQUÍ ---
    // Usamos window.onload para esperar a que TODO (incluido Select2) esté cargado.
    document.addEventListener('DOMContentLoaded', function() {
        const $ = window.jQuery;

        console.log("El documento está listo. jQuery y Select2 (incluido en Vite) están disponibles.");

        let productoIndex = 1;

        function calcularSubtotal(row) {
            const cantidad = parseFloat($(row).find('.producto-cantidad').val()) || 0;
            const valor = parseFloat($(row).find('.producto-valor').val()) || 0;
            const subtotal = cantidad * valor;
            $(row).find('.producto-subtotal').val(subtotal.toFixed(2));
        }

        function initializeSelect2(elements) {
            elements.each(function() {
                const $element = $(this);
                if (!$element.hasClass('select2-hidden-accessible')) {
                    $element.select2({
                        placeholder: "Buscar...",
                        allowClear: true,
                        width: '100%'
                    });
                }
            });
        }

        // --- FUNCIÓN PARA AÑADIR UN PRODUCTO (VERSIÓN CON ORDEN CORRECTO) ---
        $('#addProducto').on('click', function() {
            const templateHtml = $('#producto-template').html();
            const newRows = $(templateHtml);

            // Actualizar nombres en las nuevas filas
            newRows.find('[name]').each(function() {
                const name = $(this).attr('name').replace('INDEX', productoIndex);
                $(this).attr('name', name);
            });

            // Llenar selects
            const colorSelect = newRows.find('select[name="productos[' + productoIndex + '][codcolor]"]');
            const tallaSelect = newRows.find('select[name="productos[' + productoIndex + '][codtalla]"]');

            colorSelect.empty().append('<option value="">Seleccionar...</option>');
            tallaSelect.empty().append('<option value="">Seleccionar...</option>');
            window.coloresData.forEach(c => colorSelect.append(`<option value="${c.codcolor}">${c.nombrecolor}</option>`));
            window.tallasData.forEach(t => tallaSelect.append(`<option value="${t.codtalla}">${t.nombretalla}</option>`));

            // --- ¡LA CLAVE! Añadir las filas antes del botón ---
            // Buscamos el div que contiene el botón y añadimos las nuevas filas justo antes que él.
            newRows.insertBefore('#addProducto');
            // ---------------------------------------------------

            // Inicializar Select2
            initializeSelect2(newRows.find('.js-example-basic-single'));

            productoIndex++;
        });
        // --- FIN DE LA FUNCIÓN ---

        $(document).on('change', '.producto-select', function() {
            calcularSubtotal($(this).closest('tr'));
        });
        $(document).on('input', '.producto-cantidad, .producto-valor', function() {
            calcularSubtotal($(this).closest('tr'));
        });

        // --- FUNCIÓN PARA ELIMINAR UN ÍTEM (VERSIÓN DEFINITIVA) ---
        // --- FUNCIÓN PARA ELIMINAR UN ÍTEM (CON DEPURACIÓN) ---
        $(document).on('click', '.eliminar-producto', function(e) {
            e.preventDefault();

            // 1. Encuentra la fila donde está el botón (la segunda fila del ítem)
            const secondRow = $(this).closest('tr');
            console.log("Fila del botón (segunda fila):", secondRow);

            // 2. Encuentra la fila anterior (la primera fila del ítem)
            const firstRow = secondRow.prev();
            console.log("Fila anterior (primera fila):", firstRow);

            // 3. Cuenta cuántos ítems hay
            const currentItemCount = $('.item-group').length;
            console.log("Cantidad total de ítems:", currentItemCount);

            if (currentItemCount > 1) {
                // 4. Elimina ambas filas
                firstRow.remove();
                secondRow.remove();
                console.log("Ítem eliminado.");
            } else {
                alert('Debe tener al menos un producto.');
            }
        });
        // --- FIN DE LA FUNCIÓN ---


        $('#codcp').change(function() {
            const codcli = $(this).val();
            const sucursalSelect = $('#codsuc');
            if (codcli) {
                $.get(`/ordenes-pedido/sucursales/${codcli}`, function(data) {
                    sucursalSelect.empty().append('<option value="">Seleccione una sucursal</option>');
                    if (data.length > 0) {
                        data.forEach(s => sucursalSelect.append(`<option value="${s.codsuc}">${s.nombresuc}</option>`));
                    }
                });
            } else {
                sucursalSelect.empty().append('<option value="">Seleccione una sucursal</option>');
            }
        });

        // Inicialización inicial de Select2
        initializeSelect2($('.js-example-basic-single'));

        // Establecer fecha de entrega por defecto
        const fechaEntrega = new Date();
        fechaEntrega.setDate(fechaEntrega.getDate() + 7);
        $('#fechent').val(fechaEntrega.toISOString().split('T')[0]);
    });

    // --- Cierre del window.onload ---
</script>

@endpush