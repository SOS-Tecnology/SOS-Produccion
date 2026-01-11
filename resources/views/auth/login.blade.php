@extends('layouts.app')

@section('title', 'Iniciar Sesión')

@section('content')
<div class="flex items-center justify-center min-h-screen">
    {{-- Contenedor principal del formulario --}}
    <div class="w-96 bg-white rounded-2xl shadow-2xl border border-gray-200 overflow-hidden">
        
        {{-- Cabecera con el título --}}
        <div class="bg-gray-100 px-8 pt-6 pb-4">
            <h1 class="text-2xl font-bold text-center text-gray-800">Iniciar Sesión</h1>
        </div>

        {{-- Cuerpo del formulario --}}
        <div class="px-8 py-6">
            @if ($errors->any())
                <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded-lg text-sm">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="email" class="block text-gray-700 text-sm font-semibold mb-2">Correo Electrónico</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" 
                           class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500" 
                           required autocomplete="email" autofocus>
                </div>

                <div class="mb-6">
                    <label for="password" class="block text-gray-700 text-sm font-semibold mb-2">Contraseña</label>
                    <input id="password" type="password" name="password" 
                           class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500" 
                           required autocomplete="current-password">
                </div>

                <div class="flex justify-center">
                    <button type="submit" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:shadow-outline transition duration-300 ease-in-out">
                        Aceptar
                    </button>
                </div>
            </form>
        </div>

        {{-- Pie de página con el enlace --}}
        <div class="px-8 pb-6">
            <div class="text-center">
                <a href="{{ route('register') }}" class="text-blue-500 hover:text-blue-700 text-sm font-semibold">
                    ¿No tienes una cuenta? Regístrate
                </a>
            </div>
        </div>
    </div>
</div>
@endsection