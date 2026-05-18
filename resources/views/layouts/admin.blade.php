@props([
    'title' => config('app.name', 'Olan Barber'),
    'breadcrumbs' => [],
])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title }} | Olan Barber</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        {{-- Font Awesome CSS --}}
        <script src="https://kit.fontawesome.com/bf2462bedb.js" crossorigin="anonymous"></script>

        {{-- SweetAlert2 --}}
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        {{-- WireUI --}}
        <wireui:scripts />
        
        <!-- Styles -->
        @livewireStyles
    </head>
    <body class="font-sans antialiased bg-[#0b0b0c] text-[#f4f4f6]">

        @include('layouts.includes.admin.navigation')
        @include('layouts.includes.admin.sidebar')

        <div class="p-4 sm:ml-64 mt-14 min-h-screen flex flex-col justify-between">
            <div>
                <div class="mb-6 flex items-start justify-between">
                    <div>
                        @include('layouts.includes.admin.breadcrumb')
                    </div>
                    @isset($action)
                        <div class="flex-shrink-0">
                            {{$action}}
                        </div>
                    @endisset
                </div>
                
                <div class="bg-[#121215] rounded-2xl shadow-xl border border-[#222227] overflow-hidden">
                    {{$slot}}
                </div>
            </div>

            <!-- Footer -->
            <footer class="mt-12 py-6 text-center text-xs text-gray-600 border-t border-[#1a1a1f]">
                &copy; {{ date('Y') }} Olan Barber. Todos los derechos reservados.
            </footer>
        </div>

        @stack('modals')
        
        {{-- SweetAlert session notifications --}}
        @if (session('swal'))
            <script>
                Swal.fire(@json(session('swal')));
            </script> 
        @endif

        @livewireScripts
        <script src="https://cdn.jsdelivr.net/npm/flowbite@4.0.1/dist/flowbite.min.js"></script>

        {{-- Confirm delete helper --}}
        <script>
            forms = document.querySelectorAll('.delete-form');
            forms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: '¿Estás seguro?',
                        text: 'No podrás revertir esta acción',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Sí, eliminar',
                        cancelButtonText: 'Cancelar' 
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        </script>
    </body>
</html>
