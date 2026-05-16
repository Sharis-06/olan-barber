<x-admin-layout title="Servicios" :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard')
    ],
    [
        'name' => 'Servicios',
    ],
]">

    {{-- BOTÓN DE ACCIÓN (NUEVO SERVICIO) --}}
    <x-slot name="action">
        <x-wire-button blue href="{{ route('admin.service.create') }}">
            <i class="fa-solid fa-plus"></i>
            Nuevo
        </x-wire-button>
    </x-slot>

    {{-- TABLA LIVEWIRE --}}
    @livewire('admin.datatables.service-table')

</x-admin-layout>