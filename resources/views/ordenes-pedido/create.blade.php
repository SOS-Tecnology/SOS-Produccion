@extends('layouts.dashboard')

@section('title', 'Nuevo pedido')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="md:flex md:items-center md:justify-between">
            <div class="flex-1 min-w-0">
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">Nuevo pedido</h2>
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
            <form action="{{ route('ordenes-pedido.store') }}" method="POST" autocomplete="off">
                @csrf
                <!-- Encabezado -->
                <div class="px-4 py-5 sm:px-6 space-y-6 bg-slate-50 rounded-t-lg">
                    @if ($errors->any())
                    <div class="rounded-md bg-red-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <!-- Icono de error -->
                                <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Errores en el formulario</h3>
                                <div class="mt-2 text-sm text-red-700">
                                    <ul class="list-disc pl-5 space-y-1">
                                        @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                        <div class="sm:col-span-2">
                            <label for="documento" class="block text-sm font-medium text-gray-700">N.° de documento</label>
                            <div class="mt-1">
                                <input type="text" name="documento" id="documento" value="{{ $nuevoDocumento ?? '' }}" class="shadow-sm bg-gray-100 block w-full sm:text-sm border-gray-300 rounded-md" readonly>
                            </div>
                        </div>
                        <div class="sm:col-span-2">
                            <label for="codcp" class="block text-sm font-medium text-gray-700">Cliente</label>
                            <div class="mt-1">
                                <select id="codcp" name="codcp" class="js-example-basic-single shadow-sm block w-full sm:text-sm border-gray-300 rounded-md" required>
                                    <option value="">Seleccionar...</option>
                                    @foreach($clientes as $cliente)
                                    <option value="{{ $cliente->codcli }}">{{ $cliente->nombrecli }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="sm:col-span-2">
                            <label for="codsuc" class="block text-sm font-medium text-gray-700">Sucursal</label>
                            <div class="mt-1">
                                <select id="codsuc" name="codsuc" class="shadow-sm block w-full sm:text-sm border-gray-300 rounded-md">
                                    <option value="">Seleccione una sucursal</option>
                                </select>
                            </div>
                        </div>
                        <div class="sm:col-span-2">
                            <label for="fecha" class="block text-sm font-medium text-gray-700">Fecha del pedido</label>
                            <div class="mt-1">
                                <input type="date" name="fecha" id="fecha" value="{{ date('Y-m-d') }}" class="shadow-sm block w-full sm:text-sm border-gray-300 rounded-md" required>
                            </div>
                        </div>
                        <div class="sm:col-span-2">
                            <label for="fechent" class="block text-sm font-medium text-gray-700">Fecha de entrega</label>
                            <div class="mt-1">
                                <input type="date" name="fechent" id="fechent" class="shadow-sm block w-full sm:text-sm border-gray-300 rounded-md" required>
                            </div>
                        </div>
                        <div class="sm:col-span-2">
                            <label for="estado" class="block text-sm font-medium text-gray-700">Estado</label>
                            <div class="mt-1">
                                <select id="estado" name="estado" class="shadow-sm block w-full sm:text-sm border-gray-300 rounded-md">
                                    <option value="P" selected>Pendiente</option>
                                    <option value="A">Aprobada</option>
                                    <option value="C">Completada</option>
                                    <option value="X">Cancelada</option>
                                </select>
                            </div>
                        </div>
                        <div class="sm:col-span-6">
                            <label for="comen" class="block text-sm font-medium text-gray-700">Comentarios</label>
                            <div class="mt-1">
                                <textarea id="comen" name="comen" rows="1" class="shadow-sm block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Comentarios generales del orden..."></textarea>
                            </div>
                        </div>
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
                                <!-- GRUPO DE RENGLONES PARA EL PRIMER PRODUCTO -->
                            <tbody class="item-group">
                                <!-- Renglón 1: Datos principales -->
                                <tr class="producto-row">
                                    <td class="px-2 py-2 align-top">
                                        <select class="producto-select js-example-basic-single shadow-sm block w-full text-sm border-gray-300 rounded-md" name="productos[0][codr]" required>
                                            <option value="">Seleccionar...</option>
                                            @foreach($productos as $producto)
                                            <option value="{{ $producto->codr }}">{{ $producto->codr }} - {{ $producto->descr }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="px-2 py-2 align-top">
                                        <select class="shadow-sm block w-full text-sm border-gray-300 rounded-md" name="productos[0][codcolor]">
                                            <option value="">Seleccionar...</option>
                                            @foreach($colores as $color)
                                            <option value="{{ $color['codcolor'] }}">{{ $color['nombrecolor'] }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="px-2 py-2 align-top">
                                        <select class="shadow-sm block w-full text-sm border-gray-300 rounded-md" name="productos[0][codtalla]">
                                            <option value="">Seleccionar...</option>
                                            @foreach($tallas as $talla)
                                            <option value="{{ $talla['codtalla'] }}">{{ $talla['nombretalla'] }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="px-2 py-2 align-top"><input type="number" class="producto-cantidad shadow-sm block w-full text-sm border-gray-300 rounded-md" name="productos[0][cantidad]" step="1" min="1" required></td>
                                    <td class="px-2 py-2 align-top"><input type="number" class="producto-valor shadow-sm block w-full text-sm border-gray-300 rounded-md" name="productos[0][valor]" step="0.01" min="0" required></td>
                                    <td class="px-2 py-2 align-top"><input type="text" class="producto-subtotal shadow-sm bg-gray-100 block w-full text-sm border-gray-300 rounded-md" name="productos[0][subtotal]" readonly></td>
                                    <td class="px-2 py-2 align-top text-center">
                                        <!-- Esta celda está vacía, el botón está en la siguiente fila -->
                                    </td>
                                </tr>
                                <!-- Renglón 2: Comentarios y Botón Eliminar -->
                                <tr>
                                    <td colspan="6" class="px-2 py-1 align-top">
                                        <textarea name="productos[0][comencpo]" rows="1" class="shadow-sm block w-full text-sm border-gray-300 rounded-md" placeholder="Comentarios del ítem..."></textarea>
                                    </td>
                                    <td class="px-2 py-1 text-right align-top">
                                        <button type="button" class="eliminar-producto text-red-600 hover:text-red-900">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                            <!-- Aquí se agregarán los nuevos grupos de renglones -->
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        <button type="button" id="addProducto" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            + Agregar Producto
                        </button>
                    </div>
                </div>

                <!-- --- PLANTILLA FINAL Y CORRECTA --- -->
                <template id="producto-template">
                    <tr class="producto-row item-group">
                        <td class="px-2 py-2 align-top w-1/3">
                            <select class="producto-select js-example-basic-single shadow-sm block w-full text-sm border-gray-300 rounded-md" name="productos[INDEX][codr]" required>
                                <option value="">Seleccionar...</option>
                                @foreach($productos as $producto)
                                <option value="{{ $producto->codr }}">{{ $producto->codr }} - {{ $producto->descr }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td class="px-2 py-2 align-top w-24">
                            <select class="shadow-sm block w-full text-sm border-gray-300 rounded-md" name="productos[INDEX][codcolor]">
                            </select>
                        </td>
                        <td class="px-2 py-2 align-top w-24">
                            <select class="shadow-sm block w-full text-sm border-gray-300 rounded-md" name="productos[INDEX][codtalla]">
                            </select>
                        </td>
                        <td class="px-2 py-2 align-top w-20"><input type="number" class="producto-cantidad shadow-sm block w-full text-sm border-gray-300 rounded-md" name="productos[INDEX][cantidad]" step="1" min="1" required></td>
                        <td class="px-2 py-2 align-top w-28"><input type="number" class="producto-valor shadow-sm block w-full text-sm border-gray-300 rounded-md" name="productos[INDEX][valor]" step="0.01" min="0" required></td>
                        <td class="px-2 py-2 align-top w-28"><input type="text" class="producto-subtotal shadow-sm bg-gray-100 block w-full text-sm border-gray-300 rounded-md" name="productos[INDEX][subtotal]" readonly></td>
                        <td class="px-2 py-2 align-top text-center w-16"></td>
                    </tr>
                    <tr>
                        <td colspan="6" class="px-2 py-1 align-top">
                            <textarea name="productos[INDEX][comencpo]" rows="1" class="shadow-sm block w-full text-sm border-gray-300 rounded-md" placeholder="Comentarios del ítem..."></textarea>
                        </td>
                        <td class="px-2 py-1 text-right align-top">
                            <button type="button" class="eliminar-producto text-red-600 hover:text-red-900">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </td>
                    </tr>
                </template>
                <!-- ----------------------------------- -->

                <!-- Botones -->
                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6 border-t border-gray-200">
                    <button type="submit" class="bg-indigo-600 border border-transparent rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Guardar orden
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
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    /* --- ESTILOS PARA SELECT2 (sin cambios) --- */
    .select2-container {
        width: 100% !important;
    }

    .select2-container--default .select2-selection--single {
        font-size: 0.875rem;
        height: 2.5rem;
        padding-top: 0.5rem;
        padding-bottom: 0.5rem;
        border-radius: 0.375rem;
        border-color: rgb(209 213 219);
    }

    .select2-dropdown {
        font-size: 0.875rem;
    }

    .select2-results__option {
        font-size: 0.875rem;
        padding: 0.5rem 0.75rem;
    }

    /* --- NUEVA REGLA "MAZO" PARA FORZAR ANCHO --- */
    /* Esta regla apunta directamente a los inputs/selects/textarea dentro de cualquier fila de la tabla de productos */
    #productos-tbody tr td>input,
    #productos-tbody tr td>select,
    #productos-tbody tr td>textarea {
        width: 100% !important;
        max-width: 100% !important;
        box-sizing: border-box !important;
    }

    /* --------------------------------------------- */
</style>
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