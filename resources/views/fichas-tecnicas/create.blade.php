@extends('layouts.dashboard')

@section('title', 'Nueva Ficha Técnica')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="md:flex md:items-center md:justify-between mb-6">
                <div class="flex-1 min-w-0">
                    <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                        Nueva Ficha Técnica
                    </h2>
                </div>
                <div class="mt-4 flex md:mt-0 md:ml-4">
                    <a href="{{ route('fichas-tecnicas.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Volver al Listado
                    </a>
                </div>
            </div>

            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <form action="{{ route('fichas-tecnicas.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
                    @csrf

                    {{-- Mensaje de error general --}}
                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <strong class="font-bold">¡Error!</strong>
                            <span class="block sm:inline">Por favor, corrige los siguientes campos:</span>
                            <ul class="mt-2 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <div class="mb-3">
                                <label for="id_producto_base" class="block text-gray-700 text-xs font-semibold mb-1">Producto Base:</label>
                                <select name="id_producto_base" id="id_producto_base" class="js-example-basic-single shadow appearance-none border rounded w-full py-1.5 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                    <option value="">-- Seleccione un producto --</option>
                                    {{-- Usamos la variable $productosBase como en tu controlador --}}
                                    @foreach($productosBase as $producto)
                                        <option value="{{ $producto->codr }}">{{ $producto->descr }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="id_cliente" class="block text-gray-700 text-xs font-semibold mb-1">Cliente:</label>
                                <select name="id_cliente" id="id_cliente" class="js-example-basic-single shadow appearance-none border rounded w-full py-1.5 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                    <option value="">-- Seleccione un cliente --</option>
                                    {{-- Usamos la variable $clientes como en tu controlador --}}
                                    @foreach($clientes as $cliente)
                                        <option value="{{ $cliente->codcli }}">{{ $cliente->nombrecli }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="nombre_ficha" class="block text-gray-700 text-xs font-semibold mb-1">Nombre de la Ficha:</label>
                                <input type="text" name="nombre_ficha" id="nombre_ficha" class="shadow appearance-none border rounded w-full py-1.5 px-3 text-sm text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                            </div>

                            <div class="mb-3">
                                <label for="adicionales" class="block text-gray-700 text-xs font-semibold mb-1">Adicionales:</label>
                                <textarea name="adicionales" id="adicionales" rows="3" class="shadow appearance-none border rounded w-full py-1.5 px-3 text-sm text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                            </div>
                        </div>

                        <div>
                            <div class="mb-3">
                                <label for="tiempo_corte" class="block text-gray-700 text-xs font-semibold mb-1">Tiempo de Corte (min):</label>
                                <input type="number" step="0.01" name="tiempo_corte" id="tiempo_corte" class="shadow appearance-none border rounded w-full py-1.5 px-3 text-sm text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div>

                            <div class="mb-3">
                                <label for="tiempo_confeccion" class="block text-gray-700 text-xs font-semibold mb-1">Tiempo de Confección (min):</label>
                                <input type="number" step="0.01" name="tiempo_confeccion" id="tiempo_confeccion" class="shadow appearance-none border rounded w-full py-1.5 px-3 text-sm text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div>

                            <div class="mb-3">
                                <label for="tiempo_alistamiento" class="block text-gray-700 text-xs font-semibold mb-1">Tiempo de Alistamiento (min):</label>
                                <input type="number" step="0.01" name="tiempo_alistamiento" id="tiempo_alistamiento" class="shadow appearance-none border rounded w-full py-1.5 px-3 text-sm text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div>

                            <div class="mb-3">
                                <label for="tiempo_remate" class="block text-gray-700 text-xs font-semibold mb-1">Tiempo de Remate (min):</label>
                                <input type="number" step="0.01" name="tiempo_remate" id="tiempo_remate" class="shadow appearance-none border rounded w-full py-1.5 px-3 text-sm text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div>
                        </div>
                    </div>

                    {{-- Sección de Fotos (solo para añadir nuevas) --}}
                    <div class="mt-6 p-4 bg-gray-50 rounded">
                        <h3 class="text-lg font-semibold mb-3">Fotos del Producto</h3>
                        <div class="mb-3">
                            <label for="fotos" class="block text-gray-700 text-xs font-semibold mb-1">Añadir Fotos:</label>
                            <input type="file" name="fotos[]" id="fotos" multiple accept="image/*" class="shadow appearance-none border rounded w-full py-1.5 px-3 text-sm text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <p class="text-xs text-gray-500 mt-1">Puedes seleccionar varias imágenes a la vez.</p>
                        </div>
                    </div>

                    <div class="flex items-center justify-between mt-6">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Crear Ficha Técnica
                        </button>
                        <a href="{{ route('fichas-tecnicas.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Incluir CSS y JS de Select2 --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script>
        $(document).ready(function() {
            $('.js-example-basic-single').select2({
                placeholder: "Buscar...",
                allowClear: true
            });
        });
    </script>
@endsection