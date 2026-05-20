<x-admin-layout title="Roles" :breadcrumbs="[
        [
            'name' => 'Dashboard',
            'href' => route('admin.dashboard')
        ],

        [
            'name' => 'Roles',
            'href' => route('admin.roles.index'),
        ],
        [
            'name' => 'Crear',
            
        ]

    ]">

    <x-wire-card>
        <form action="{{route('admin.roles.store')}}" method="POST">
            @csrf
            <x-wire-input label="Nombre" name="name" placeholder="Nombre del rol" 
            value="{{old('name')}}"></x-wire-input>
                <div class="flex justify-end gap-3 mt-4">
                    <x-wire-button href="{{ route('admin.roles.index') }}" secondary>
                        Cancelar
                    </x-wire-button>
                    <x-wire-button type="submit" blue> Guardar </x-wire-button>
                </div>
            
            
        </form>    
    </x-wire-card>  

</x-admin-layout>