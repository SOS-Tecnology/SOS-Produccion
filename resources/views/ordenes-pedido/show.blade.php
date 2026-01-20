@extends('layouts.dashboard')

@section('title', 'Detalle del Pedido')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="md:flex md:items-center md:justify-between">
            <div class="flex-1 min-w-0">
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">Pedido #{{ $orden->documento }}</h2>
            </div>
            <div class="mt-4 flex md:mt-0 md:ml-4 space-x-2">
                <a href="{{ route('ordenes-pedido.edit', $orden->documento) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-indigo-700 bg-indigo-50 hover:bg-indigo-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Editar
                </a>
                <a href="{{ route('ordenes-pedido.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Volver
                </a>
            </div>
        </div>
    </div>

    <div class="max-w-screen-2xl mx-auto mt-8 sm:px-6 lg:px-8">
        <div class="bg-white shadow overflow-hidden sm:rounded-md">
            <div class="px-4 py-5 sm:px-6 space-y-4 bg-slate-50 rounded-t-lg">
                <dl class="grid grid-cols-1 gap-x-4 gap-y-4 sm:grid-cols-2">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">N.° de Documento</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $orden->documento }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Cliente</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            {{ optional($orden->cliente)->nombrecli ?? 'Cliente no asignado' }}
                        </dd>

                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Fecha del Pedido</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ \Carbon\Carbon::parse($orden->fecha)->format('d/m/Y') }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Fecha de Entrega</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ \Carbon\Carbon::parse($orden->fechent)->format('d/m/Y') }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Estado</dt>
                        <dd class="mt-1">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                @if($orden->estado == 'P') bg-yellow-100 text-yellow-800
                                @elseif($orden->estado == 'A') bg-green-100 text-green-800
                                @elseif($orden->estado == 'C') bg-blue-100 text-blue-800
                                @else bg-red-100 text-red-800 @endif">
                                {{ $orden->estado }}
                            </span>
                        </dd>
                    </div>
                </dl>
                @if($orden->comen)
                <div class="mt-4">
                    <dt class="text-sm font-medium text-gray-500">Comentarios Generales</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $orden->comen }}</dd>
                </div>
                @endif
            </div>

            <div class="px-4 sm:px-6 bg-white border-t border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900 my-3">Productos</h3>
            </div>
            <div class="px-4 sm:px-6 bg-white pb-4">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Producto</th>
                                <th class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Detalles</th>
                                <th class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cantidad</th>
                                <th class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">V. Unidad.</th>
                                <th class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orden->detalles as $producto)
                            <tr>
                                <td class="px-2 py-2">
                                    <div class="font-medium text-gray-900">{{ $producto->descr }}</div>
                                    @if($producto->codcolor && $producto->codtalla)
                                    <div class="text-gray-500">{{ $producto->codcolor }}, {{ $producto->codtalla }}</div>
                                    @endif
                                </td>
                                <td class="px-2 py-2 text-gray-500">{{ $producto->comencpo }}</td>
                                <td class="px-2 py-2 text-gray-900">{{ $producto->cantidad }}</td>
                                <td class="px-2 py-2 text-gray-900">{{ number_format($producto->valor, 2) }}</td>
                                <td class="px-2 py-2 text-gray-900">{{ number_format($producto->cantidad * $producto->valor, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection