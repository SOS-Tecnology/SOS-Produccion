@extends('layouts.dashboard')

@section('title', 'Panel de Control')

@section('content')
<div class="mb-6">
    <h2 class="text-3xl font-bold text-gray-800">Panel de Control</h2>
    <p class="text-gray-600">Selecciona una opción para comenzar</p>
</div>

{{-- Grid de Botones de Acceso Rápido --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

    {{-- Botón: Gestionar Satélites --}}
    <a href="{{ route('satelites.index') }}" class="group bg-white p-6 rounded-xl shadow-lg border border-gray-200 hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 ease-in-out">
        <div class="flex items-center space-x-4">
            <div class="flex-shrink-0 w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center group-hover:bg-purple-200 transition-colors">
                {{-- Icono de Lista --}}
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                </svg>
            </div>
            <div class="min-w-0 flex-1">
                <h3 class="text-lg font-semibold text-gray-800 group-hover:text-purple-600 truncate">Gestionar Satélites</h3>
                <p class="text-sm text-gray-500">Ver, editar o eliminar satélites existentes.</p>
            </div>
        </div>
    </a>

    {{-- Botón: Gestionar Fichas Técnicas --}}
    <a href="{{ route('fichas-tecnicas.index') }}" class="group bg-white p-6 rounded-xl shadow-lg border border-gray-200 hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 ease-in-out">
        <div class="flex items-center space-x-4">
            <div class="flex-shrink-0 w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center group-hover:bg-orange-200 transition-colors">
                {{-- Icono de Lista --}}
                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                </svg>
            </div>
            <div class="min-w-0 flex-1">
                <h3 class="text-lg font-semibold text-gray-800 group-hover:text-orange-600 truncate">Gestionar Fichas</h3>
                <p class="text-sm text-gray-500">Ver, editar o eliminar fichas técnicas.</p>
            </div>
        </div>
    </a>
    <!-- Agregar en la sección de botones de acceso rápido -->
    {{-- Botón: Gestión de Órdenes de Pedido --}}
    <a href="{{ route('ordenes-pedido.index') }}" class="group bg-white p-6 rounded-xl shadow-lg border border-gray-200 hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 ease-in-out">
        <div class="flex items-center space-x-4">
            <div class="flex-shrink-0 w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center group-hover:bg-blue-200 transition-colors">
                {{-- Icono de Carrito de Compras/Pedido --}}
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
            </div>
            <div class="min-w-0 flex-1">
                <h3 class="text-lg font-semibold text-gray-800 group-hover:text-blue-600 truncate">Gestión de Órdenes de Pedido</h3>
                <p class="text-sm text-gray-500">Crear, editar y dar seguimiento a las órdenes de pedido.</p>
            </div>
        </div>
    </a>
</div>
@endsection