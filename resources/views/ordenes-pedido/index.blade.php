@extends('layouts.dashboard')

@section('title', 'Lista de Órdenes de Pedido')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Lista de Órdenes de Pedido</h1>

    <a href="{{ route('ordenes-pedido.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4 inline-block">
        Crear Nueva Orden
    </a>

    @if(isset($ordenes) && $ordenes->isEmpty())
        <p class="text-gray-600">No hay órdenes de pedido registradas.</p>
    @else
        <div class="overflow-x-auto bg-white rounded-lg shadow-md">
            <table class="min-w-full">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Documento</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Cliente</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Fecha Pedido</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Fecha Entrega</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Valor Total</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Estado</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($ordenes ?? [] as $orden)
                        <tr>
                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900">{{ $orden->documento }}</td>
                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900">{{ $orden->cliente->nombrecli ?? 'N/A' }}</td>
                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900">{{ $orden->fecha->format('d/m/Y') }}</td>
                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900">{{ $orden->fechent ? $orden->fechent->format('d/m/Y') : 'N/A' }}</td>
                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900">{{ number_format($orden->valortotal, 2, ',', '.') }}</td>
                            <td class="px-4 py-2 whitespace-nowrap">
                                @switch($orden->estado)
                                    @case('P')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pendiente</span>
                                        @break
                                    @case('A')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Aprobada</span>
                                        @break
                                    @case('C')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Completada</span>
                                        @break
                                    @case('X')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Cancelada</span>
                                        @break
                                    @default
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">{{ $orden->estado }}</span>
                                @endswitch
                            </td>
                            <td class="px-4 py-2 whitespace-nowrap text-sm font-medium space-x-2">
                                <a href="{{ route('ordenes-pedido.show', $orden->documento) }}" class="text-indigo-600 hover:text-indigo-900">Ver</a>
                                <a href="{{ route('ordenes-pedido.edit', $orden->documento) }}" class="text-indigo-600 hover:text-indigo-900">Editar</a>
                                <form action="{{ route('ordenes-pedido.destroy', $orden->documento) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Está seguro de que desea eliminar esta orden de pedido?');">
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
                            <td colspan="7" class="px-4 py-2 text-center text-gray-600">No hay órdenes de pedido registradas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @endif
@endsection