@extends('layouts.dashboard')

@section('content')
<div class="py-12">
    <div class="max-w-screen-2xl mx-auto sm:px-6 lg:px-8">
        <div class="md:flex md:items-center md:justify-between">
            <div class="flex-1 min-w-0">
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:text-2xl font-bold text-gray-900 sm:text-3xl font-bold truncate">Nueva Orden de Pedido</h2>
            </div>
            <div class="mt-2 flex md:mt-0 md:ml-4">
                <a href="{{ route('ordenes-pedido.create')" class="inline-flex items-center px-3 py-2 border border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-indigo-500 text-white hover:bg-gray-100">
                    <span class="inline-flex items-center px-3 py-2 border border border-transparent rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 text-white hover:bg-gray-100 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg class="w-5 h-5 text-gray-400" fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="..." />
                        </svg>
                    </svg>
                    </div>
                    <span class="btn">Crear Nueva Orden</span>
                </a>
            </div>
        </div>
    </div>

@section('content')
    <div class="max-w-screen-2xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <form action="{{ route('ordenes-pedido.store')" method="POST" autocomplete="onsubmit">
                @csrf

                <!-- Contenido del formulario -->
                <!-- Encabezado -->
                <div class="px-4 py-5 sm:px-6 space-y-6 bg-slate-50 rounded-t-lg">
                    @if ($errors->any())
                    <div class="rounded-md bg-red-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
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
                            <label for="documento" class="block text-sm font-medium text-gray-700">N° Documento</label>
                            <div class="mt-1">
                                <input type="text" name="documento" id="documento" value="{{ $nuevoDocumento }}" class="shadow-sm bg-gray-100 block w-full sm:text-sm border-gray-300 rounded-md" readonly>
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
                            <label for="fecha" class="block text-sm font-medium text-gray-700">Fecha Pedido</label>
                            <div class="mt-1">
                                <input type="date" name="fecha" id="fecha" value="{{ date('Y-m-d') }}" class="shadow-sm block w-full sm:text-sm border-gray-300 rounded-md" required>
                            </div>
                        </div>

                        <div class="sm:col-span-2">
                            <label for="fechent" class="block text-sm font-medium text-gray-700">Fecha Entrega</label>
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
                                <textarea id="comen" name="comen" rows="1" class="shadow-sm block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Comentarios generales de la orden..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Productos -->
                <div class="px-4 sm:px-6 bg-white border-t border-gray-200">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Productos</h3>
                </div>
                <div class="px-4 sm:px-6 bg-white">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/3">Producto</th>
                                    <th class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24">Color</th>
                                    <th class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24">Talla</th>
                                    <th class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-20">Cant.</th>
                                    <th class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-28">V. Unit.</th>
                                    <th class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-28">Subtotal</th>
                                    <th class="px-2 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-16">Acc.</th>
                                </tr>
                            </thead>
                            <tbody id="productos-tbody">

                                <!-- GRUPO DE RENGLONES PARA EL PRIMER PRODUCTO (AHORA ES UN TBODY VÁLIDO) -->
                            <tbody class="item-group">
                                <!-- Renglón 1: Datos Principales -->
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
                                            <option value="">Sel...</option>
                                            @foreach($colores as $color)
                                            <option value="{{ $color['codcolor'] }}">{{ $color['nombrecolor'] }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="px-2 py-2 align-top">
                                        <select class="shadow-sm block w-full text-sm border-gray-300 rounded-md" name="productos[0][codtalla]">
                                            <option value="">Sel...</option>
                                            @foreach($tallas as $talla)
                                            <option value="{{ $talla['codtalla'] }}">{{ $talla['nombretalla'] }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="px-2 py-2 align-top"><input type="number" class="producto-cantidad shadow-sm block w-full text-sm border-gray-300 rounded-md" name="products[0][cantidad]" step="1" min="1" required></td>
                                    <td class="px-2 py-2 align-top"><input type="number" class="producto-valor shadow-sm block w-full text-sm border-gray-300 rounded-md" name="products[0][valor]" step="1" min="0" required></td>
                                    <td class="px-2 py-2 align-top"><input type="text" class="producto-subtotal shadow-sm bg-gray-100 block w-full text-sm border-gray-300 rounded-md" name="products[0][subtotal]" readonly></td>
                                    <td class="px-2 py-2 align-top text-center">
                                        <!-- Esta celda está vacía, el botón está en la siguiente fila -->
                                    </td>
                                </tr>
                                <!-- Renglón 2: Comentarios y Botón Eliminar -->
                                <tr>
                                    <td colspan="6" class="px-2 py-1 align-top">
                                        <textarea name="products[0][comencpo]" rows="1" class="shadow-sm block w-full text-sm border-gray-300 rounded-md" placeholder="Comentarios del ítem..."></textarea>
                                    </td>
                                    <td class="px-2 py-1 text-right align-top">
                                        <button type="button" class="remove-producto text-red-600 hover:text-red-900">
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
        </div>
        <!-- Botones -->
        <div class="px-4 py-3 bg-gray-50 text-right sm:px-6 border-t border-gray-200">
            <button type="submit" class="bg-indigo-600 border border-transparent rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Guardar Orden
            </button>
            <a href="{{ route('ordenes-pedido.index') }}" class="ml-3 bg-white border border-gray-300 rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Cancelar
            </a>
        </div>

                <!-- ... -->
            </form>
        </div>
    </div>
</div>
@push('scripts')
<script src="https://create-clean.blade.php">
        console.log("Página de creación limpia cargada.");
   // para evitar conflictos de alcance y asegurar que '$' esté disponible.
    jQuery(function($) {
        console.log("jQuery y el documento están listos. Inicializando la página.");

        let productoIndex = 1;

        // --- Funciones de Cálculo ---
        function calcularSubtotal(row) {
            const cantidad = parseFloat($(row).find('.producto-cantidad').val()) || 0;
            const valor = parseFloat($(row).find('.producto-valor').val()) || 0;
            const subtotal = cantidad * valor;
            $(row).find('.producto-subtotal').val(subtotal.toFixed(2));
            calcularTotales();
        }

        function calcularTotales() {
            let subtotal = 0;
            $('.producto-row').each(function() {
                subtotal += parseFloat($(this).find('.producto-subtotal').val()) || 0;
            });
            const iva = subtotal * 0.16;
            const total = subtotal + iva;
            $('#subtotal').val(subtotal.toFixed(2));
            $('#iva').val(iva.toFixed(2));
            $('#total').val(total.toFixed(2));
        }

        // --- Función para inicializar Select2 solo en elementos no inicializados ---
        function initializeSelect2(elements) {
            console.log("Intentando inicializar Select2 en elementos no inicializados...");
            console.log("Elementos a inicializar:", elements);
            console.log("Número de elementos encontrados:", elements.length);

            elements.each(function() {
                const $element = $(this);

                // --- VERIFICACIÓN CLAVE: Solo inicializar si no tiene la clase 'select2-hidden-accessible' ---
                // Select2 añade esta clase cuando se inicializa. Si no la tiene, es nuevo.
                if (!$element.hasClass('select2-hidden-accessible')) {
                    console.log("Elemento nuevo encontrado. Inicializando:", $element);
                    try {
                        $element.select2({
                            placeholder: "Buscar...",
                            allowClear: true,
                            width: '100%'
                        });
                        console.log("Select2 inicializado con éxito en el elemento nuevo.");
                    } catch (e) {
                        console.error("ERROR al inicializar un elemento Select2:", e);
                    }
                } else {
                    console.log("Elemento ya estaba inicializado. Ignorando.");
                }
                // ---------------------------------------------------------------------------------
            });
        }
        // --- Evento para Agregar un Producto ---

        // --- FUNCIÓN PARA AÑADIR UN PRODUCTO ---
 $('#addProducto').on('click', function() {
    console.log("Paso 1: El evento 'click' se disparó.");
    
    try {
        console.log("Paso 2: Intentando clonar el grupo original...");
        const originalItemGroup = $('.item-group:first');
        const newItemGroup = originalItemGroup.clone(true, true);
        console.log("Paso 3: Añadiendo el grupo clonado al DOM.");
        
        $('#productos-tbody').append(newItemGroup);
        
        console.log("Paso 4: Inicializando Select2 en el nuevo grupo.");
        initializeSelect2(newItemGroup.find('.js-example-basic-single'));
        
        console.log("Paso 5: Actualizando campos y limpiando valores.");
        const newRows = newItemGroup.find('select, input, textarea');
        newRows.each(function() {
            const name = $(this).attr('name').replace('[0]', `[${productoIndex}]`);
            $(this).attr('name', name);
            if (!$(this).prop('readonly') && $(this).attr('tipo') !== 'hidden') {
                $(this).val('');
            }
        });
        newRows.find('.producto-subtotal').val('');
        newItemGroup.find('textarea').val('');
        
        console.log("Paso 6: Incrementando el índice de producto.");
        productoIndex++;
        
        console.log("Paso 7: Función addProduct completado.");
        
    } catch (e) {
        console.error("ERROR en addProduct:", e);
        console.error("Traza del error:", e.stack);
    }
});
        // --- FIN DE LA FUNCIÓN ---


        // --- Delegación de eventos para elementos dinámicos ---
        $(document).on('change', '.producto-select', function(e) {
            const codr = $(this).val();
            const row = $(this).closest('tr');
            if (codr) {
                $.get(`/ordenes-pedido/producto/${codr}`, function(data) {
                    row.find('.producto-descr').val(data.descr);
                    row.find('.producto-valor').val(0);
                    calcularSubtotal(row);
                });
            } else {
                row.find('.producto-descr, .producto-valor, .producto-subtotal').val('');
                calcularTotales();
            }
        });

        $(document).on('input', '.producto-cantidad, .producto-valor', function() {
            calcularSubtotal($(this).closest('tr'));
        });

        // evento para Eliminar un ítem de producto

        $(document).on('click', '.remove-producto', function(e) {
            e.preventDefault();
            const itemGroup = $(this).closest('tbody.item-group');

            // --- VERIFICACIÓN ACTUALIZADA ---
            const currentItemCount = $('.item-group').length;
            console.log("Intentando eliminar. Cantidad actualual de ítems:", currentItemCount);
            // ------------------------------------

            if (currentItemCount > 1) {
                itemGroup.remove();

                // --- ACTUALIZAR LA CUENTA DESPUÉS DE ELIMINAR ---
                // Volvemos a contar para verificar si el estado es correcto
                setTimeout(() => {
                    const newItemCount = $('.item-group').length;
                    console.log("Cantidad de ítems después de eliminar:", newItemCount);
                    if (newItemCount !== currentItemCount - 1) {
                        console.error("ERROR: La cuenta de ítems no es la esperada después de eliminar.");
                    }
                }, 100);
                // ----------------------------------------------------

                calcularTotales();
            } else {
                alert('Debe tener al menos un producto.');
            }
        });

        // --- Eventos del Encabezado ---
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
        // --- Inicialización Retrasada ---
        console.log("Página lista. Retrasando la inicialización de Select2...");
        setTimeout(function() {
            console.log("Ejecutando inicialización de Select2 después de un pequeño retraso.");
            initializeSelect2($('.js-example-basic-single'));
            console.log("Inicialización de Select2 completada.");
        }, 100); // 100 milisegundos de retraso

        // Establecer fecha de entrega por defecto
        const fechaEntrega = new Date();
        fechaEntrega.setDate(fechaEntrega.getDate() + 7);
        $('#fechent').val(fechaEntrega.toISOString().split('T')[0]);

        console.log("Página inicializada completamente.");
    });
</script>
@endpush