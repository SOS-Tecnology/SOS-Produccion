@extends('layouts.app')

@section('title', 'Registrarse')

@section('content')
<div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="w-full max-w-md">
        <div class="bg-white p-8 rounded-lg shadow-md">
            <h1 class="text-2xl font-bold text-center mb-6">Crear Cuenta</h1>

            {{-- Mostrar errores de validación --}}
            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nombre Completo</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required autocomplete="name" autofocus>
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Correo Electrónico</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required autocomplete="email">
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Contraseña</label>
                    <input id="password" type="password" name="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required autocomplete="new-password">
                </div>

                <div class="mb-6">
                    <label for="password_confirmation" class="block text-gray-700 text-sm font-bold mb-2">Confirmar Contraseña</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required autocomplete="new-password">
                </div>

                <div class="flex items-center justify-between">
                    <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full">
                        Registrarse
                    </button>
                </div>
            </form>

            <div class="mt-6 text-center">
                <a href="{{ route('login') }}" class="text-blue-500 hover:text-blue-700 text-sm">
                    ¿Ya tienes una cuenta? Inicia sesión
                </a>
            </div>
        </div>
    </div>
</div>
@endsection