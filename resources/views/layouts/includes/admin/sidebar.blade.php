@php
$links = [

    [
        'name' => 'Dashboard',
        'icon' => 'fa-solid fa-gauge',
        'href' => route('dashboard'),
        'active' => request()->routeIs('dashboard')
    ],

    [
        'header' => 'Gestión'
    ],

    [
        'name' => 'Clientes',
        'icon' => 'fa-solid fa-users',
        'href' => '#',
        'active' => request()->routeIs('clients.*')
    ],

    [
        'name' => 'Servicios',
        'icon' => 'fa-solid fa-scissors',
        'href' => '#',
        'active' => request()->routeIs('services.*')
    ],

    [
        'name' => 'Citas',
        'icon' => 'fa-solid fa-calendar-check',
        'href' => '#',
        'active' => request()->routeIs('appointments.*')
    ],

    [
        'header' => 'Administración'
    ],

    [
        'name' => 'Roles',
        'icon' => 'fa-solid fa-shield-halved',
        'href' => route('admin.roles.index'),
        'active' => request()->routeIs('admin.roles.*'),
    ],

    [
        'name' => 'Usuarios',
        'icon' => 'fa-solid fa-user',
        'href' => route('admin.users.index'),
        'active' => request()->routeIs('admin.users.*'),
    ],

];

@endphp

<aside class="fixed top-0 left-0 z-40 w-64 h-screen">
    <div class="h-full px-3 py-4 overflow-y-auto bg-black text-white">
        <a href="#" class="flex items-center mb-8">
            <img src="{{asset('images/logo.jpeg')}}" class="h-6 me-3" alt="Olan Barber">
            <span class="text-2xl font-bold">
                OLAN 
            </span>
        </a>

        <ul class="space-y-2 font-medium">
            @foreach ($links as $link)
                <li>
                    @isset($link['header'])
                        <div class="px-2 py-3 text-xs uppercase text-gray-400 font-bold">
                            {{ $link['header'] }}
                        </div>
                    @else
                        <a
                            href="{{ $link['href'] }}"
                            class="flex items-center p-3 rounded-lg transition hover:bg-gray-800
                            {{ $link['active'] ? 'bg-gray-800' : '' }}"
                        >
                            <i class="{{ $link['icon'] }} w-5 h-5"></i>
                            <span class="ml-3">
                                {{ $link['name'] }}
                            </span>
                        </a>
                    @endisset
                </li>
            @endforeach
        </ul>
    </div>
</aside>