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

    <div class="bg-[#121215] border border-[#222227] rounded-2xl p-6 md:p-8 shadow-2xl space-y-6 relative overflow-hidden">
        <div class="absolute right-0 bottom-0 opacity-[0.02] transform translate-x-12 translate-y-12 select-none pointer-events-none">
            <i class="fa-solid fa-file-signature text-[250px] text-[#c5a880]"></i>
        </div>

        <div class="flex items-center gap-3 border-b border-[#222227] pb-4">
            <div class="w-10 h-10 rounded-xl bg-[#1a1a1f] flex items-center justify-center text-[#c5a880] text-lg border border-[#222227]">
                <i class="fa-solid fa-pen-to-square"></i>
            </div>
            <div>
                <h2 class="text-xl font-black text-[#f4f4f6]">Editar Detalles de la Cita</h2>
                <p class="text-xs text-gray-500 font-medium">Modifica la información del cliente, barbero, servicio u horario asignado.</p>
            </div>
        </div>

        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-950/20 border border-red-900/30 text-red-400 rounded-xl">
                <ul class="list-disc list-inside text-xs font-semibold space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.appointments.update', $appointment) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <div class="grid lg:grid-cols-2 gap-6">

                    {{-- CLIENT --}}
                    <div class="space-y-1.5">
                        <label class="text-xs font-bold text-[#c5a880] uppercase tracking-wider block">Cliente</label>
                        <x-wire-native-select
                            name="user_id"
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
                    </div>

                    {{-- BARBER --}}
                    <div class="space-y-1.5">
                        <label class="text-xs font-bold text-[#c5a880] uppercase tracking-wider block">Barbero</label>
                        <x-wire-native-select
                            name="barber_id"
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
                    </div>

                    {{-- SERVICE --}}
                    <div class="space-y-1.5">
                        <label class="text-xs font-bold text-[#c5a880] uppercase tracking-wider block">Servicio</label>
                        <x-wire-native-select
                            name="service_id"
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
                    </div>

                    {{-- DATE --}}
                    <div class="space-y-1.5">
                        <label class="text-xs font-bold text-[#c5a880] uppercase tracking-wider block">Fecha</label>
                        <input
                            type="date"
                            name="fecha"
                            required
                            value="{{ old('fecha', $appointment->fecha) }}"
                            class="w-full border border-[#222227] bg-[#1a1a1f] text-gray-200 rounded-xl p-3 focus:border-[#c5a880] focus:ring-1 focus:ring-[#c5a880] focus:outline-none transition font-medium shadow-sm"
                        />
                    </div>

                    {{-- TIME --}}
                    <div class="space-y-1.5">
                        <label class="text-xs font-bold text-[#c5a880] uppercase tracking-wider block">Hora</label>
                        <input
                            type="time"
                            name="hora"
                            required
                            value="{{ old('hora', \Carbon\Carbon::parse($appointment->hora)->format('H:i')) }}"
                            class="w-full border border-[#222227] bg-[#1a1a1f] text-gray-200 rounded-xl p-3 focus:border-[#c5a880] focus:ring-1 focus:ring-[#c5a880] focus:outline-none transition font-medium shadow-sm"
                        />
                    </div>

                    {{-- STATUS --}}
                    <div class="space-y-1.5">
                        <label class="text-xs font-bold text-[#c5a880] uppercase tracking-wider block">Estado</label>
                        <x-wire-native-select
                            name="estado"
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

                </div>

                <div class="flex justify-end gap-3 border-t border-[#222227] pt-6">
                    <a
                        href="{{ route('admin.appointments.index') }}"
                        class="bg-[#1a1a1f] hover:bg-[#222227] text-gray-300 font-extrabold px-6 py-3 rounded-xl transition duration-300 border border-[#222227] cursor-pointer text-sm flex items-center justify-center"
                    >
                        Cancelar
                    </a>
                    <a
                        href="{{ route('admin.appointments.pdf', $appointment) }}"
                        target="_blank"
                        class="bg-[#1a1a1f] hover:bg-[#222227] text-[#c5a880] font-extrabold px-6 py-3 rounded-xl transition duration-300 border border-[#222227] cursor-pointer text-sm flex items-center justify-center gap-1.5"
                    >
                        <i class="fa-solid fa-file-pdf text-[#c5a880]"></i>
                        Descargar Ticket
                    </a>
                    <button
                        type="submit"
                        class="bg-gradient-to-r from-[#c5a880] to-[#a2835b] hover:from-[#d4b790] hover:to-[#b2936a] text-black font-extrabold px-6 py-3 rounded-xl transition duration-300 transform active:scale-95 shadow-lg shadow-[#c5a880]/10 border-none cursor-pointer text-sm flex items-center justify-center gap-1.5"
                    >
                        <i class="fa-solid fa-floppy-disk"></i>
                        Actualizar cita
                    </button>
                </div>

            </div>
        </form>
    </div>

</x-admin-layout>
