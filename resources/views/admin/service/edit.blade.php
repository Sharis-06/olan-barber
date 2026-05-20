<x-admin-layout title="Servicios" :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard')
    ],

    [
        'name' => 'Servicios',
        'href' => route('admin.service.index'),
    ],

    [
        'name' => 'Editar',
    ]
]">

    <x-wire-card>

        {{-- ERRORES DE VALIDACIÓN --}}
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.service.update', $service) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-4">

                <div class="grid lg:grid-cols-2 gap-4">

                    <x-wire-input
                        label="Nombre del servicio"
                        name="nombre"
                        placeholder="Ej. Corte de cabello"
                        required
                        :value="old('nombre', $service->nombre)"
                    />

                    <x-wire-input
                        label="Precio"
                        name="precio"
                        type="number"
                        step="0.01"
                        placeholder="Ej. 120"
                        required
                        inputmode="decimal"
                        :value="old('precio', $service->precio)"
                    />

                    <x-wire-input
                        label="Duración (minutos)"
                        name="duracion_minutos"
                        type="number"
                        placeholder="Ej. 30"
                        required
                        inputmode="numeric"
                        :value="old('duracion_minutos', $service->duracion_minutos)"
                    />

                    <x-wire-input
                        label="Descripción"
                        name="descripcion"
                        type="text"
                        placeholder="Ej. Corte de cabello estilo moderno"
                        :value="old('descripcion', $service->descripcion)"
                    />

                </div>

                <div class="flex justify-end gap-3">
                    <x-wire-button href="{{ route('admin.service.index') }}" secondary>
                        Cancelar
                    </x-wire-button>
                    <x-wire-button type="submit" blue>
                        Actualizar servicio
                    </x-wire-button>
                </div>

            </div>

    </form>

    </x-wire-card>

</x-admin-layout>