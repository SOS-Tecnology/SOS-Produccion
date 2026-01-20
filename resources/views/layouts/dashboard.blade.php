<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistema de Producción')</title>
    <!-- CARGA JQUERY PRIMERO -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- Mueve las líneas de Select2 AQUÍ -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased" style="background-image: url('https://images.unsplash.com/photo-1557683316-973673baf926?q=80&w=2070&auto=format&fit=crop'); background-size: cover; background-position: center; background-attachment: fixed;">

    {{-- Header Principal --}}
    <header class="bg-white shadow-md">
        <div class="container mx-auto px-6 py-3 flex items-center justify-between">

            {{-- Lado Izquierdo: Logo y Nombre de la Empresa --}}
            <div class="flex items-center space-x-3">
                {{-- Placeholder para el logo --}}
                <div class="w-10 h-10 bg-gray-300 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                    </svg>
                </div>
                <h1 class="text-xl font-semibold text-gray-800">D & D Dotaciones y Deportes S.A.S </h1>
            </div>
            {{-- LADO CENTRAL: Botón Volver --}}
            <div class="flex-shrink-0">
                <a href="{{ route('dashboard') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold text-sm py-2 px-3 rounded-lg focus:outline-none focus:shadow-outline transition duration-300">
                    Volver
                </a>
            </div>

            {{-- Lado Derecho: Menú de Usuario --}}
            <div class="relative group">
                {{-- Botón que activa el menú --}}
                <button class="flex items-center space-x-2 text-gray-700 hover:text-gray-900 focus:outline-none">
                    <span class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                        </svg>
                    </span>
                    <span class="hidden md:block font-medium">{{ Auth::user()->name }}</span>
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>

                {{-- Menú Desplegable (Dropdown) --}}
                <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 z-10 invisible group-hover:visible opacity-0 group-hover:opacity-100 transform scale-95 group-hover:scale-100 transition-all duration-200 ease-in-out origin-top-right">
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Mi Perfil</a>
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Configuración</a>

                    <div class="border-t border-gray-100 my-2"></div>

                    {{-- Formulario de Cierre de Sesión --}}
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            Cerrar Sesión
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    {{-- Contenido Principal de la Página --}}
    <main class="container mx-auto p-6 max-w-5xl">
        @yield('content')
    </main>
    {{-- Scripts Adicionales --}}
    @stack('scripts')

</body>

</html>