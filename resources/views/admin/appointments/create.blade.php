<x-admin-layout title="Nueva Cita" :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard')
    ],

    [
        'name' => 'Citas',
        'href' => route('admin.appointments.index'),
    ],

    [
        'name' => 'Nueva Cita',
    ]
]">

    @livewire('client-booking')

</x-admin-layout>