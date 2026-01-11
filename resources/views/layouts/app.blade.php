<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="es">

<!-- resources/views/layouts/app.blade.php -->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistema de Producción')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<!-- <body class="bg-gray-100 font-sans antialiased"> -->
<body class="font-sans antialiased" style="background-image: url('https://images.unsplash.com/photo-1557683316-973673baf926?q=80&w=2070&auto=format&fit=crop'); background-size: cover; background-position: center; background-attachment: fixed;">    
    <!-- Scripts comunes para toda la aplicación -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <div class="container mx-auto p-6 max-w-5xl">
        @yield('content')
    </div>
    <!-- El script de navegación con "Enter" ahora vive aquí -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            if (!form) return;

            form.addEventListener('keydown', function(event) {
                if (event.key === 'Enter') {
                    event.preventDefault();
                    const focusableElements = form.querySelectorAll('input:not([type="submit"]), select, textarea');
                    let targetField = null;

                    focusableElements.forEach(el => {
                        if (el === document.activeElement || el.contains(document.activeElement)) {
                            targetField = el;
                        }
                    });

                    if (targetField) {
                        const currentIndex = Array.from(focusableElements).indexOf(targetField);
                        if (currentIndex < focusableElements.length - 1) {
                            focusableElements[currentIndex + 1].focus();
                        } else if (currentIndex === focusableElements.length - 1) {
                            form.submit();
                        }
                    }
                }
            });
        });
        // Función para inicializar Select2
        function initializeSelect2() {
            // Usamos un 'setTimeout' para dar un pequeño margen de seguridad
            setTimeout(() => {
                if (typeof $ !== 'undefined' && $.fn.select2) {
                    $('#proveedor-select').select2({
                        placeholder: "Buscar un proveedor...",
                        allowClear: true
                    });
                }
            }, 100); // Espera 100 milisegundos antes de inicializar
        }

        $(document).ready(function() {
            initializeSelect2();
        });
    </script>
</body>

</html>