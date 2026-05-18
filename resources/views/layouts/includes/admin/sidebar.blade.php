@php
$user = auth()->user();
$links = [];

if ($user && $user->hasRole('Cliente')) {
    $links = [
        [
            'name' => 'Mi Dashboard',
            'icon' => 'fa-solid fa-gauge',
            'href' => route('dashboard'),
            'active' => request()->routeIs('dashboard')
        ],

        [
            'header' => 'Servicios'
        ],

        [
            'name' => 'Reservar Cita',
            'icon' => 'fa-solid fa-calendar-plus',
            'href' => route('client.booking'),
            'active' => request()->routeIs('client.booking')
        ],
    ];
} else {
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
            'name' => 'Servicios',
            'icon' => 'fa-solid fa-scissors',
            'href' => route('admin.service.index'),
            'active' => request()->routeIs('admin.service.*')
        ],

        [
            'name' => 'Barberos',
            'icon' => 'fa-solid fa-users',
            'href' => '#',
            'active' => request()->routeIs('admin.barberos.*')
        ],

        [
            'name' => 'Citas',
            'icon' => 'fa-solid fa-calendar-check',
            'href' => route('admin.appointments.index'),
            'active' => request()->routeIs('admin.appointments.*')
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
}
@endphp

<aside class="fixed top-0 left-0 z-40 w-64 h-screen border-r border-[#222227] pt-14">
    <div class="h-full px-4 py-6 overflow-y-auto bg-[#121215]">
        <!-- Brand Title -->
        <div class="px-2 py-4 mb-4 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl overflow-hidden border-2 border-[#c5a880]/30 shadow-md flex items-center justify-center bg-black flex-shrink-0">
                <img src="{{asset('images/logo.jpeg')}}" class="w-full h-full object-cover" alt="Logo">
            </div>
            <div>
                <h1 class="text-base font-black tracking-widest text-[#f4f4f6] leading-none uppercase">OLAN</h1>
                <span class="text-[11px] font-bold text-[#c5a880] tracking-[0.25em] uppercase">BARBERSHOP</span>
            </div>
        </div>

        <ul class="space-y-1.5 font-medium">
            @foreach ($links as $link)
                <li>
                    @isset($link['header'])
                        <div class="px-3 py-3 text-[10px] uppercase text-[#c5a880]/70 font-black tracking-[0.2em] mt-4 border-b border-[#222227]/50 mb-1">
                            {{ $link['header'] }}
                        </div>
                    @else
                        <a
                            href="{{ $link['href'] }}"
                            class="flex items-center p-3 rounded-xl transition duration-200 font-semibold text-sm cursor-pointer
                            {{ $link['active'] 
                                ? 'bg-gradient-to-r from-[#c5a880] to-[#a2835b] text-black shadow-lg shadow-[#c5a880]/10 font-bold' 
                                : 'text-gray-400 hover:bg-[#1a1a1f] hover:text-[#c5a880]' }}"
                        >
                            <i class="{{ $link['icon'] }} w-5 h-5 flex items-center justify-center text-base"></i>
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