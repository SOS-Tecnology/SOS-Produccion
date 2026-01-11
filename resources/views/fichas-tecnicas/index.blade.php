@extends('layouts.dashboard')

@section('title', 'Lista de Fichas Técnicas')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Lista de Fichas Técnicas</h1>

    <a href="{{ route('fichas-tecnicas.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4 inline-block">
        Crear Nueva Ficha
    </a>

    @if(isset($fichas) && $fichas->isEmpty())
        <p class="text-gray-600">No hay fichas técnicas registradas.</p>
    @else
        <div class="overflow-x-auto bg-white rounded-lg shadow-md">
            <table class="min-w-full">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">ID</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Nombre Ficha</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Producto Base</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Cliente</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($fichas ?? [] as $ficha)
                        <tr>
                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900">{{ $ficha->id }}</td>
                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900">{{ $ficha->nombre_ficha }}</td>
                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900">{{ $ficha->productoBase?->descr ?? 'N/A' }}</td>
                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900">{{ $ficha->cliente?->nombrecli ?? 'N/A' }}</td>
                            <td class="px-4 py-2 whitespace-nowrap text-sm font-medium space-x-2">
                                <a href="{{ route('fichas-tecnicas.edit', $ficha->id) }}" class="text-indigo-600 hover:text-indigo-900">Editar</a>
                                <form action="{{ route('fichas-tecnicas.destroy', $ficha->id) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Está seguro de que desea eliminar esta ficha técnica?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-2 text-center text-gray-600">No hay fichas técnicas registradas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @endif
@endsection