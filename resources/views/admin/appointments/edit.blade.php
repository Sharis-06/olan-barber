<x-admin-layout title="Editar Cita" :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard')
    ],

    [
        'name' => 'Citas',
        'href' => route('admin.appointments.index'),
    ],

    [
        'name' => 'Editar',
    ]
]">

    <x-wire-card>

        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">

                <ul class="list-disc list-inside text-sm">

                    @foreach ($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>
        @endif

        <form action="{{ route('admin.appointments.update', $appointment) }}" method="POST">

            @csrf
            @method('PUT')

            <div class="space-y-4">

                <div class="grid lg:grid-cols-2 gap-4">

                    {{-- CLIENT --}}
                    <x-wire-native-select
                        name="user_id"
                        label="Cliente"
                        required
                    >

                        <option value="">
                            Seleccionar cliente
                        </option>

                        @foreach ($clients as $client)

                            <option
                                value="{{ $client->id }}"
                                @selected(old('user_id', $appointment->user_id) == $client->id)
                            >
                                {{ $client->name }}
                            </option>

                        @endforeach

                    </x-wire-native-select>

                    {{-- BARBER --}}
                    <x-wire-native-select
                        name="barber_id"
                        label="Barbero"
                        required
                    >

                        <option value="">
                            Seleccionar barbero
                        </option>

                        @foreach ($barbers as $barber)

                            <option
                                value="{{ $barber->id }}"
                                @selected(old('barber_id', $appointment->barber_id) == $barber->id)
                            >
                                {{ $barber->name }}
                            </option>

                        @endforeach

                    </x-wire-native-select>

                    {{-- SERVICE --}}
                    <x-wire-native-select
                        name="service_id"
                        label="Servicio"
                        required
                    >

                        <option value="">
                            Seleccionar servicio
                        </option>

                        @foreach ($services as $service)

                            <option
                                value="{{ $service->id }}"
                                @selected(old('service_id', $appointment->service_id) == $service->id)
                            >
                                {{ $service->nombre }}
                            </option>

                        @endforeach

                    </x-wire-native-select>

                    {{-- DATE --}}
                    <x-wire-input
                        type="date"
                        name="fecha"
                        label="Fecha"
                        required
                        :value="old('fecha', $appointment->fecha)"
                    />

                    {{-- TIME --}}
                    <x-wire-input
                        type="time"
                        name="hora"
                        label="Hora"
                        required
                        :value="old('hora', \Carbon\Carbon::parse($appointment->hora)->format('H:i'))"
                    />

                    {{-- STATUS --}}
                    <x-wire-native-select
                        name="estado"
                        label="Estado"
                        required
                    >

                        <option value="pendiente" @selected(old('estado', $appointment->estado) == 'pendiente')>
                            Pendiente
                        </option>

                        <option value="confirmada" @selected(old('estado', $appointment->estado) == 'confirmada')>
                            Confirmada
                        </option>

                        <option value="completada" @selected(old('estado', $appointment->estado) == 'completada')>
                            Completada
                        </option>

                        <option value="cancelada" @selected(old('estado', $appointment->estado) == 'cancelada')>
                            Cancelada
                        </option>

                    </x-wire-native-select>

                </div>

                <div class="flex justify-end">

                    <x-wire-button type="submit" blue>

                        Actualizar cita

                    </x-wire-button>

                </div>

            </div>

        </form>

    </x-wire-card>

</x-admin-layout>
