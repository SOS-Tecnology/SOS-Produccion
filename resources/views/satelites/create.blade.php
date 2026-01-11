<!-- resources/views/satelites/create.blade.php -->
@extends('layouts.dashboard')

@section('title', 'Crear Nuevo Satélite')

@section('content')
<h1 class="text-2xl font-bold mb-4">Crear Nuevo Satélite</h1>

<div class="bg-white p-4 rounded-lg shadow-md">
    <form action="/satelites" method="POST">
        @csrf

        <div class="mb-2">
            <label for="id_proveedor" class="block text-gray-700 text-sm font-bold mb-2">Proveedor:</label>
            <select name="id_proveedor" id="proveedor-select" class="shadow appearance-none border rounded w-full py-1.5 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                <option value="">-- Seleccione un proveedor --</option>
                @foreach($proveedores as $proveedor)
                <option value="{{ $proveedor->codp }}">{{ $proveedor->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-2">
            <label for="tipo" class="block text-gray-700 text-sm font-bold mb-2">Tipo:</label>
            <select name="tipo" id="tipo" class="shadow appearance-none border rounded w-full py-1.5 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                <option value="Corte">Corte</option>
                <option value="Confeccion">Confeccion</option>
            </select>
        </div>

        <div class="mb-2">
            <label for="especialidad" class="block text-gray-700 text-sm font-bold mb-2">Especialidad:</label>
            <input type="text" name="especialidad" id="especialidad" class="shadow appearance-none border rounded w-full py-1.5 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>

        <div class="mb-2">
            <label for="capacidad_produccion" class="block text-gray-700 text-sm font-bold mb-2">Capacidad (p/semana):</label>
            <input type="number" name="capacidad_produccion" id="capacidad_produccion" class="shadow appearance-none border rounded w-full py-1.5 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>

        <div class="mb-2">
            <label for="calificacion" class="block text-gray-700 text-sm font-bold mb-2">Calificación:</label>
            <input type="number" step="0.1" name="calificacion" id="calificacion" min="0" max="5" class="shadow appearance-none border rounded w-full py-1.5 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>

        <div class="mb-2">
            <label for="comentarios" class="block text-gray-700 text-sm font-bold mb-2">Comentarios:</label>
            <textarea name="comentarios" id="comentarios" rows="3" class="shadow appearance-none border rounded w-full py-1.5 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
        </div>

        <div class="mb-2">
            <label for="estado" class="block text-gray-700 text-sm font-bold mb-2">Estado:</label>
            <select name="estado" id="estado" class="shadow appearance-none border rounded w-full py-1.5 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                <option value="Activo">Activo</option>
                <option value="Bloqueado">Bloqueado</option>
            </select>
        </div>

        <div class="flex items-center justify-between">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1.5 px-4 rounded focus:outline-none focus:shadow-outline">
                Guardar Satélite
            </button>
            <a href="/satelites" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-1.5 px-4 rounded focus:outline-none focus:shadow-outline">
                Cancelar
            </a>
        </div>
    </form>
</div>

@endsection

<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" /> 
<script> $(document).ready(function() { $('#proveedor-select').select2({ placeholder: "Buscar un proveedor...", allowClear: true }); }); </script>


