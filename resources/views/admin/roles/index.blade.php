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
        <a
            href="{{route('admin.roles.create')}}"
            class="inline-flex items-center gap-2 bg-gradient-to-r from-[#c5a880] to-[#a2835b] hover:from-[#d4b790] hover:to-[#b2936a] text-black font-extrabold px-5 py-2.5 rounded-xl transition duration-300 transform hover:scale-105 shadow-lg shadow-[#c5a880]/10 border-none cursor-pointer text-sm"
        >
            <i class="fa-solid fa-plus text-sm"></i>
            Nuevo Rol
        </a>
    </x-slot>

    @livewire('admin.datatables.role-table')

</x-admin-layout>