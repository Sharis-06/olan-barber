<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Olan Barber</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles
</head>

<body class="bg-gray-100">

    <div class="flex min-h-screen">
        @include('layouts.includes.admin.sidebar')
        <div class="flex-1 sm:ml-64">
            @include('layouts.includes.admin.navigation')
            <main class="p-6 mt-16">
                @include('layouts.includes.admin.breadcrumb')
                @yield('content')
            </main>
        </div>
    </div>
    @livewireScripts
</body>
</html>