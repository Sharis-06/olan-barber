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
        'name' => 'Crear',
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

        <form action="{{ route('admin.service.store') }}" method="POST">
            @csrf

            <di class="space-y-4">

                <div class="grid lg:grid-cols-2 gap-4">

                    {{-- NOMBRE DEL SERVICIO --}}
                    <x-wire-input
                        label="Nombre del servicio"
                        name="nombre"
                        placeholder="Ej. Corte de cabello"
                        required
                        :value="old('nombre')"
                    />

                    {{-- PRECIO --}}
                    <x-wire-input
                        label="Precio"
                        name="precio"
                        type="number"
                        step="0.01"
                        placeholder="Ej. 120"
                        required
                        inputmode="decimal"
                        :value="old('precio')"
                    />

                    {{-- DURACIÓN --}}
                    <x-wire-input
                        label="Duración (minutos)"
                        name="duracion_minutos"
                        type="number"
                        placeholder="Ej. 30"
                        required
                        inputmode="numeric"
                        :value="old('duracion_minutos')"
                    />

                    {{-- DESCRIPCION --}}
                    <x-wire-input
                        label="Descripción"
                        name="descripcion"
                        type="text"
                        placeholder="Ej. Corte de cabello estilo moderno"
                        :value="old('descripcion')"
                    />

                </div>

                <div class="flex justify-end">
                    <x-wire-button type="submit" blue>
                        Guardar servicio
                    </x-wire-button>
                </div>

            </div>

        </form>

    </x-wire-card>

</x-admin-layout>