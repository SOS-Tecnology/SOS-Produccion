<!-- resources/views/satelites/index.blade.php -->
@extends('layouts.dashboard')

@section('title', 'Lista de Satélites')

@section('content')
<h1 class="text-2xl font-bold mb-4">Lista de Satélites</h1>

<a href="/satelites/create" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4 inline-block">
    Crear Nuevo Satélite
</a>

@if($satelites->isEmpty())
<p class="text-gray-600">No hay satélites registrados.</p>
@else
<div class="overflow-x-auto bg-white rounded-lg shadow-md">
    <table class="min-w-full">
        <thead class="bg-gray-200">
            <tr>
                <th class="px-4 py-2 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">ID</th>
                <th class="px-4 py-2 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Nombre del Proveedor</th>
                <th class="px-4 py-2 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Tipo</th>
                <th class="px-4 py-2 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Estado</th>
                <th class="px-4 py-2 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Acciones</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach($satelites as $satelite)
            <tr>
                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900">{{ $satelite->id }}</td>
                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900">{{ $satelite->proveedor->nombre ?? 'N/A' }}</td>
                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900">{{ $satelite->tipo }}</td>
                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900">{{ $satelite->estado }}</td>
                <td class="px-4 py-2 whitespace-nowrap text-sm font-medium space-x-2">
                    <a href="/satelites/{{ $satelite->id }}/edit" class="text-indigo-600 hover:text-indigo-900">Editar</a>

                    {{-- Formulario para Eliminar --}}
                    <form action="{{ route('satelites.destroy', $satelite->id) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Está seguro de que desea eliminar este satélite?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900">
                            Eliminar
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif
@endsection