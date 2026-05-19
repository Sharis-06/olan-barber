<x-admin-layout title="Servicios" :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard')
    ],
    [
        'name' => 'Servicios',
    ],
]">

    <x-slot name="action">
        <a
            href="{{ route('admin.service.create') }}"
            class="inline-flex items-center gap-2 bg-gradient-to-r from-[#c5a880] to-[#a2835b] hover:from-[#d4b790] hover:to-[#b2936a] text-black font-extrabold px-5 py-2.5 rounded-xl transition duration-300 transform hover:scale-105 shadow-lg shadow-[#c5a880]/10 border-none cursor-pointer text-sm"
        >
            <i class="fa-solid fa-plus text-sm"></i>
            Nuevo Servicio
        </a>
    </x-slot>

    {{-- TABLA LIVEWIRE --}}
    @livewire('admin.datatables.service-table')

</x-admin-layout>