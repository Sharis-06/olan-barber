<x-admin-layout title="Roles" :breadcrumbs="[
        [
            'name' => 'Dashboard',
            'href' => route('admin.dashboard')
        ],

        [
            'name' => 'Roles',
        ],
    ]">

    <x-slot name="action">
        <x-wire-button href="{{route('admin.roles.create')}}" 
            class="!bg-blue-600 !hover:bg-blue-700 !text-white px-4 py-2 rounded-xl transition-all shadow-sm flex items-center gap-2 border-none">
            <i class="fa-solid fa-plus text-sm"></i>
            <span class="font-semibold">Nuevo</span>
        </x-wire-button>
    </x-slot>

    @livewire('admin.datatables.role-table')

</x-admin-layout>