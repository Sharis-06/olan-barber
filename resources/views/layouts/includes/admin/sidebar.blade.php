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
            'href' => route('admin.dashboard'),
            'active' => request()->routeIs('admin.dashboard')
        ],
        [
            'header' => 'Agenda'
        ],
        [
            'name' => 'Citas',
            'icon' => 'fa-solid fa-calendar-check',
            'href' => route('admin.appointments.index'),
            'active' => request()->routeIs('admin.appointments.*')
        ],
        [
            'name' => 'Horarios',
            'icon' => 'fa-solid fa-clock',
            'href' => route('admin.schedules.index'),
            'active' => request()->routeIs('admin.schedules.*')
        ],
    ];

    if ($user->hasAnyRole(['Administrador', 'Super Administrador'])) {
        $links = array_merge($links, [
            [
                'header' => 'Administración'
            ],
            [
                'name' => 'Servicios',
                'icon' => 'fa-solid fa-scissors',
                'href' => route('admin.service.index'),
                'active' => request()->routeIs('admin.service.*')
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
        ]);
    }
}
@endphp

<aside class="fixed top-0 left-0 z-40 w-64 h-screen border-r border-[#222227] pt-14">
    <div class="h-full px-4 py-6 overflow-y-auto bg-[#121215]">
        <ul class="space-y-2.5 font-medium mt-6">
            @foreach ($links as $link)
                <li>
                    @isset($link['header'])
                        <div class="px-3 py-2 text-[10px] uppercase text-[#c5a880]/60 font-black tracking-[0.25em] mt-8 border-b border-[#222227]/30 mb-2">
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