<!-- resources/views/satelites/edit.blade.php -->
@extends('layouts.dashboard')

@section('title', 'Editar Satélite')

@section('content')
<h1 class="text-2xl font-bold mb-2">Editar Satélite</h1>

<div class="bg-white p-4 rounded-lg shadow-md">
    <!-- IMPORTANTE: El formulario debe apuntar a una URL de PUT/PATCH -->
    <form action="/satelites/{{ $satelite->id }}" method="POST">
        @csrf
        @method('PUT')

        <!-- <div class="mb-2">
            <label for="id_proveedor" class="block text-gray-700 text-sm font-bold mb-2">Proveedor:</label>
            <select name="id_proveedor" id="proveedor-select" class="shadow appearance-none border rounded w-full py-1.5 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                @foreach($proveedores as $proveedor) -->
        <!-- Aquí está la magia para pre-seleccionar el proveedor -->
        <!--
                <option value="{{ $proveedor->codp }}" {{ $proveedor->codp == $satelite->id_proveedor ? 'selected' : '' }}>
                    {{ $proveedor->nombre }}
                </option>
                @endforeach
            </select>
        </div> -->
        <div class="mb-2">
            <label for="proveedor_nombre" class="block text-gray-700 text-xs font-semibold mb-1">Proveedor:</label>
            <!-- El campo es de solo lectura y muestra el nombre del proveedor -->
            <input type="text" id="proveedor_nombre" name="proveedor_nombre" value="{{ $satelite->proveedor->nombre }}" readonly class="shadow appearance-none border rounded w-full py-1.5 px-3 text-sm bg-gray-100 cursor-not-allowed">
            <!-- Ocultamos el campo original que Select2 necesita para funcionar -->
            <input type="hidden" name="id_proveedor" value="{{ $satelite->id_proveedor }}">
        </div>
        <div class="mb-2">
            <label for="tipo" class="block text-gray-700 text-sm font-bold mb-2">Tipo:</label>
            <select name="tipo" id="tipo" class="shadow appearance-none border rounded w-full py-1.5 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                <option value="Corte" {{ $satelite->tipo == 'Corte' ? 'selected' : '' }}>Corte</option>
                <option value="Confeccion" {{ $satelite->tipo == 'Confeccion' ? 'selected' : '' }}>Confeccion</option>
            </select>
        </div>

        <div class="mb-2">
            <label for="especialidad" class="block text-gray-700 text-sm font-bold mb-2">Especialidad:</label>
            <input type="text" name="especialidad" id="especialidad" value="{{ $satelite->especialidad }}" class="shadow appearance-none border rounded w-full py-1.5 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>

        <div class="mb-2">
            <label for="capacidad_produccion" class="block text-gray-700 text-sm font-bold mb-2">Capacidad (p/semana):</label>
            <input type="number" name="capacidad_produccion" id="capacidad_produccion" value="{{ $satelite->capacidad_produccion }}" class="shadow appearance-none border rounded w-full py-1.5 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>

        <div class="mb-2">
            <label for="calificacion" class="block text-gray-700 text-sm font-bold mb-2">Calificación:</label>
            <input type="number" step="0.1" name="calificacion" id="calificacion" min="0" max="5" value="{{ $satelite->calificacion }}" class="shadow appearance-none border rounded w-full py-1.5 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>

        <div class="mb-2">
            <label for="comentarios" class="block text-gray-700 text-sm font-bold mb-2">Comentarios:</label>
            <textarea name="comentarios" id="comentarios" rows="3" class="shadow appearance-none border rounded w-full py-1.5 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ $satelite->comentarios }}</textarea>
        </div>

        <div class="mb-2">
            <label for="estado" class="block text-gray-700 text-sm font-bold mb-2">Estado:</label>
            <select name="estado" id="estado" class="shadow appearance-none border rounded w-full py-1.5 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                <option value="Activo" {{ $satelite->estado == 'Activo' ? 'selected' : '' }}>Activo</option>
                <option value="Bloqueado" {{ $satelite->estado == 'Bloqueado' ? 'selected' : '' }}>Bloqueado</option>
            </select>
        </div>


        <div class="flex items-center justify-between">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1.5 px-4 rounded focus:outline-none focus:shadow-outline">
                Actualizar Satélite
            </button>
            <a href="/satelites" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-1.5 px-4 rounded focus:outline-none focus:shadow-outline">
                Cancelar
            </a>
        </div>

    </form>
</div>

<!-- resources/views/satelites/edit.blade.php -->
@endsection

<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
<script>
    $(document).ready(function() {
        $('#proveedor-select').select2({
            placeholder: "Buscar un proveedor...",
            allowClear: true
        });
    });
</script>
<!-- BLOQUE DE PRUEBA DIRECTA
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#proveedor-select').select2({
            placeholder: "Buscar un proveedor...",
            allowClear: true
        });
    });
</script>

@push('scripts')
    <script>
        $(document).ready(function() {
            // Destruir cualquier instancia anterior de Select2 en este elemento
            $('#proveedor-select').select2('destroy');

            // Inicializar Select2
            $('#proveedor-select').select2({
                placeholder: "Buscar un proveedor...",
                allowClear: true,
                width: '100%'
            });
        });
    </script>
@endpush -->