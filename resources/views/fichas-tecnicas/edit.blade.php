@extends('layouts.dashboard')

@section('title', 'Editar Ficha Técnica')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Editar Ficha Técnica: {{ $ficha->nombre_ficha }}</h1>

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

    <div class="bg-white p-6 rounded-lg shadow-md">
        <form action="{{ route('fichas-tecnicas.update', $ficha->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <div class="mb-3">
                        <label for="id_producto_base" class="block text-gray-700 text-xs font-semibold mb-1">Producto Base:</label>
                        <select name="id_producto_base" id="id_producto_base" class="js-example-basic-single shadow appearance-none border rounded w-full py-1.5 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                            <option value="">-- Seleccione un producto --</option>
                            @foreach($productosBase as $producto)
                                <option value="{{ $producto->codr }}" {{ $ficha->id_producto_base == $producto->codr ? 'selected' : '' }}>{{ $producto->descr }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="id_cliente" class="block text-gray-700 text-xs font-semibold mb-1">Cliente:</label>
                        <select name="id_cliente" id="id_cliente" class="js-example-basic-single shadow appearance-none border rounded w-full py-1.5 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                            <option value="">-- Seleccione un cliente --</option>
                            @foreach($clientes as $cliente)
                                <option value="{{ $cliente->codcli }}" {{ $ficha->id_cliente == $cliente->codcli ? 'selected' : '' }}>{{ $cliente->nombrecli }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="nombre_ficha" class="block text-gray-700 text-xs font-semibold mb-1">Nombre de la Ficha:</label>
                        <input type="text" name="nombre_ficha" id="nombre_ficha" value="{{ $ficha->nombre_ficha }}" class="shadow appearance-none border rounded w-full py-1.5 px-3 text-sm text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    </div>

                    <div class="mb-3">
                        <label for="adicionales" class="block text-gray-700 text-xs font-semibold mb-1">Adicionales:</label>
                        <textarea name="adicionales" id="adicionales" rows="3" class="shadow appearance-none border rounded w-full py-1.5 px-3 text-sm text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ $ficha->adicionales }}</textarea>
                    </div>
                </div>

                <div>
                    <div class="mb-3">
                        <label for="tiempo_corte" class="block text-gray-700 text-xs font-semibold mb-1">Tiempo de Corte (min):</label>
                        <input type="number" step="0.01" name="tiempo_corte" id="tiempo_corte" value="{{ $ficha->tiempo_corte }}" class="shadow appearance-none border rounded w-full py-1.5 px-3 text-sm text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    <div class="mb-3">
                        <label for="tiempo_confeccion" class="block text-gray-700 text-xs font-semibold mb-1">Tiempo de Confección (min):</label>
                        <input type="number" step="0.01" name="tiempo_confeccion" id="tiempo_confeccion" value="{{ $ficha->tiempo_confeccion }}" class="shadow appearance-none border rounded w-full py-1.5 px-3 text-sm text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    <div class="mb-3">
                        <label for="tiempo_alistamiento" class="block text-gray-700 text-xs font-semibold mb-1">Tiempo de Alistamiento (min):</label>
                        <input type="number" step="0.01" name="tiempo_alistamiento" id="tiempo_alistamiento" value="{{ $ficha->tiempo_alistamiento }}" class="shadow appearance-none border rounded w-full py-1.5 px-3 text-sm text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    <div class="mb-3">
                        <label for="tiempo_remate" class="block text-gray-700 text-xs font-semibold mb-1">Tiempo de Remate (min):</label>
                        <input type="number" step="0.01" name="tiempo_remate" id="tiempo_remate" value="{{ $ficha->tiempo_remate }}" class="shadow appearance-none border rounded w-full py-1.5 px-3 text-sm text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                </div>
            </div>

            {{-- Sección de Fotos Existentes --}}
            <div class="mt-6 p-4 bg-gray-50 rounded">
                <h3 class="text-lg font-semibold mb-3">Fotos Actuales</h3>
                @if($ficha->fotos->isNotEmpty())
                    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                        @foreach($ficha->fotos as $foto)
                            <div class="relative group">
                                <img src="{{ Storage::url($foto->ruta_imagen) }}" alt="Foto de la ficha" class="w-full h-32 object-cover rounded shadow-md">
                                <form action="{{ route('fichas-tecnicas.fotos.destroy', [$ficha->id, $foto->id]) }}" method="POST" class="absolute top-1 right-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white rounded-full p-1 shadow hover:bg-red-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500">No hay fotos registradas para esta ficha.</p>
                @endif
            </div>

            {{-- Campo para Añadir Nuevas Fotos --}}
            <div class="mt-4">
                <label for="fotos" class="block text-gray-700 text-xs font-semibold mb-1">Añadir Nuevas Fotos:</label>
                <input type="file" name="fotos[]" id="fotos" multiple accept="image/*" class="shadow appearance-none border rounded w-full py-1.5 px-3 text-sm text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <p class="text-xs text-gray-500 mt-1">Puedes seleccionar varias imágenes para añadirlas a las existentes.</p>
            </div>

            <div class="flex items-center justify-between mt-6">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Actualizar Ficha Técnica
                </button>
                <a href="{{ route('fichas-tecnicas.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Cancelar
                </a>
            </div>
        </form>
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