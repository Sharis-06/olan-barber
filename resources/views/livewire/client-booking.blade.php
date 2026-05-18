@php
    $isAdmin = auth()->user()->hasAnyRole(['Administrador', 'Super Administrador', 'Recepcionista']);
@endphp

<div class="p-6 bg-[#0b0b0c] min-h-screen space-y-6 font-sans">

    <!-- 1. BUSCAR DISPONIBILIDAD (FILTROS SUPERIORES) -->
    <div class="bg-[#121215] rounded-2xl p-6 border border-[#222227] shadow-xl shadow-black/20">
        <h2 class="text-xl font-bold text-[#f4f4f6] mb-4 flex items-center gap-2">
            <i class="fa-solid fa-magnifying-glass text-[#c5a880]"></i>
            Buscar disponibilidad
        </h2>
        <p class="text-gray-400 text-sm mb-6 font-medium">Encuentra el horario perfecto para tu cita seleccionando una fecha y el servicio que deseas.</p>

        <div class="grid md:grid-cols-3 gap-6 items-end">
            <!-- Fecha -->
            <div class="space-y-1.5">
                <label class="text-sm font-semibold text-[#c5a880] block">Fecha</label>
                <input
                    type="date"
                    wire:model.live="selectedDate"
                    min="{{ date('Y-m-d') }}"
                    class="w-full border border-[#222227] bg-[#1a1a1f] text-gray-200 rounded-xl p-3 focus:border-[#c5a880] focus:ring-1 focus:ring-[#c5a880] focus:outline-none transition font-medium shadow-sm"
                />
            </div>

            <!-- Servicio -->
            <div class="space-y-1.5">
                <label class="text-sm font-semibold text-[#c5a880] block">Servicio</label>
                <x-wire-native-select wire:model.live="selectedServiceId">
                    <option value="">Selecciona un servicio...</option>
                    @foreach($services as $service)
                        <option value="{{ $service->id }}">
                            {{ $service->nombre }} (${{ number_format($service->precio, 2) }} - {{ $service->duracion_minutos }} min)
                        </option>
                    @endforeach
                </x-wire-native-select>
            </div>

            <!-- Botón Buscar (Indicativo/Refrescar) -->
            <div>
                <button
                    type="button"
                    class="w-full bg-gradient-to-r from-[#c5a880] to-[#a2835b] hover:from-[#d4b790] hover:to-[#b2936a] text-black font-extrabold py-3.5 px-6 rounded-xl transition duration-300 shadow-lg shadow-[#c5a880]/5 flex items-center justify-center gap-2 border-none cursor-pointer transform active:scale-98"
                >
                    <i class="fa-solid fa-rotate text-sm"></i>
                    Actualizar disponibilidad
                </button>
            </div>
        </div>
    </div>

    <!-- 2. CONTENIDO PRINCIPAL Y CHECKOUT -->
    <div class="max-w-6xl mx-auto grid lg:grid-cols-3 gap-8">

        <!-- LADO IZQUIERDO: TARJETAS DE BARBEROS Y SUS HORAS -->
        <div class="lg:col-span-2 space-y-6">

            @if(!$selectedServiceId || !$selectedDate)
                <div class="bg-[#121215] border border-[#222227] rounded-2xl p-12 text-center shadow-xl space-y-4">
                    <div class="w-16 h-16 rounded-full bg-[#1a1a1f] flex items-center justify-center mx-auto text-[#c5a880] text-2xl border border-dashed border-[#222227]">
                        <i class="fa-solid fa-circle-info"></i>
                    </div>
                    <div class="max-w-md mx-auto space-y-1.5">
                        <h3 class="font-bold text-[#f4f4f6] text-lg">Elige Fecha y Servicio</h3>
                        <p class="text-gray-400 text-sm font-medium">
                            Por favor, asegúrate de seleccionar una fecha y el tipo de servicio en la barra superior para calcular la disponibilidad en tiempo real de cada uno de nuestros barberos.
                        </p>
                    </div>
                </div>
            @else
                @foreach($barbers as $barber)
                    @php $hours = $this->getAvailableHoursForBarber($barber->id); @endphp
                    
                    <div class="bg-[#121215] rounded-2xl p-6 border border-[#222227] flex flex-col md:flex-row gap-6 items-start md:items-center justify-between transition hover:border-[#c5a880]/30 shadow-lg">
                        <!-- Perfil del Barbero -->
                        <div class="flex items-center gap-4 min-w-[200px]">
                            <div class="w-16 h-16 rounded-full bg-gradient-to-br from-[#c5a880] to-[#a2835b] text-black flex items-center justify-center text-2xl font-black border-2 border-[#121215] shadow-md flex-shrink-0">
                                {{ strtoupper(substr($barber->name, 0, 2)) }}
                            </div>
                            <div>
                                <h3 class="font-black text-[#f4f4f6] text-lg leading-tight">{{ $barber->name }}</h3>
                                <p class="text-xs font-bold text-[#c5a880] mt-1.5 uppercase tracking-wider">Estilista Profesional</p>
                            </div>
                        </div>

                        <!-- Horarios Disponibles -->
                        <div class="flex-1 w-full border-t md:border-t-0 md:border-l border-[#222227] pt-4 md:pt-0 md:pl-6 space-y-3">
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider flex items-center gap-1.5">
                                <i class="fa-solid fa-clock text-[#c5a880]"></i>
                                Horarios Disponibles:
                            </p>
                            
                            @if(empty($hours))
                                <p class="text-sm font-semibold text-red-400 bg-red-950/20 py-2 px-3 rounded-lg border border-red-900/30">
                                    Lo sentimos, este barbero no tiene horarios disponibles en la fecha seleccionada.
                                </p>
                            @else
                                <div class="grid grid-cols-4 sm:grid-cols-6 gap-2">
                                    @foreach($hours as $hourData)
                                        @if($hourData['available'])
                                            <button
                                                type="button"
                                                wire:click="selectBarberAndHour({{ $barber->id }}, '{{ $hourData['time'] }}')"
                                                class="py-2.5 rounded-xl border-2 font-bold transition duration-300 text-sm shadow-sm flex items-center justify-center cursor-pointer transform active:scale-95
                                                {{ $selectedBarberId === $barber->id && $selectedHour === $hourData['time'] 
                                                    ? 'border-[#c5a880] bg-gradient-to-r from-[#c5a880] to-[#a2835b] text-black shadow-lg shadow-[#c5a880]/10' 
                                                    : 'border-[#222227] bg-[#1a1a1f] text-gray-300 hover:border-[#c5a880] hover:text-[#c5a880]' }}"
                                            >
                                                {{ $hourData['time'] }}
                                            </button>
                                        @else
                                            <button
                                                type="button"
                                                disabled
                                                class="py-2.5 rounded-xl border border-[#222227]/30 bg-[#0f0f11] text-gray-600 font-semibold text-sm cursor-not-allowed flex items-center justify-center gap-1 opacity-40"
                                                title="No disponible"
                                            >
                                                <i class="fa-solid fa-lock text-[9px]"></i>
                                                {{ $hourData['time'] }}
                                            </button>
                                        @endif
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            @endif

        </div>

        <!-- LADO DERECHO: SIDEBAR CHECKOUT Y RESUMEN -->
        <div class="space-y-6">

            <div class="bg-[#121215] rounded-2xl p-6 border-2 border-dashed border-[#222227] sticky top-24 space-y-6 shadow-xl">
                <h2 class="text-xl font-bold text-[#f4f4f6] border-b border-[#222227] pb-3 flex items-center gap-2">
                    <i class="fa-solid fa-ticket text-[#c5a880]"></i>
                    Resumen de la cita
                </h2>

                <div class="space-y-4">
                    <!-- Servicio -->
                    <div class="flex justify-between items-start gap-4 border-b border-[#222227]/40 pb-2">
                        <span class="text-gray-500 text-xs font-bold uppercase tracking-wider">Servicio:</span>
                        <div class="text-right">
                            @if($selectedServiceId)
                                @php $activeS = $services->find($selectedServiceId); @endphp
                                <p class="font-bold text-[#f4f4f6] text-sm">{{ $activeS->nombre }}</p>
                            @else
                                <p class="text-gray-600 text-sm italic">---</p>
                            @endif
                        </div>
                    </div>

                    <!-- Barbero -->
                    <div class="flex justify-between items-start gap-4 border-b border-[#222227]/40 pb-2">
                        <span class="text-gray-500 text-xs font-bold uppercase tracking-wider">Barbero:</span>
                        <div class="text-right">
                            @if($selectedBarberId)
                                @php $activeB = $barbers->find($selectedBarberId); @endphp
                                <p class="font-bold text-[#f4f4f6] text-sm">{{ $activeB->name }}</p>
                            @else
                                <p class="text-gray-600 text-sm italic">---</p>
                            @endif
                        </div>
                    </div>

                    <!-- Fecha -->
                    <div class="flex justify-between items-start gap-4 border-b border-[#222227]/40 pb-2">
                        <span class="text-gray-500 text-xs font-bold uppercase tracking-wider">Fecha:</span>
                        <div class="text-right">
                            @if($selectedDate)
                                <p class="font-bold text-[#f4f4f6] text-sm">{{ \Carbon\Carbon::parse($selectedDate)->translatedFormat('d-m-Y') }}</p>
                            @else
                                <p class="text-gray-600 text-sm italic">---</p>
                            @endif
                        </div>
                    </div>

                    <!-- Horario -->
                    <div class="flex justify-between items-start gap-4 border-b border-[#222227]/40 pb-2">
                        <span class="text-gray-500 text-xs font-bold uppercase tracking-wider">Horario:</span>
                        <div class="text-right">
                            @if($selectedHour)
                                <p class="font-bold text-[#c5a880] text-sm">{{ $selectedHour }}</p>
                            @else
                                <p class="text-gray-600 text-sm italic">---</p>
                            @endif
                        </div>
                    </div>

                    <!-- Duración -->
                    <div class="flex justify-between items-start gap-4 pb-2">
                        <span class="text-gray-500 text-xs font-bold uppercase tracking-wider">Duración:</span>
                        <div class="text-right">
                            @if($selectedServiceId)
                                @php $activeS = $services->find($selectedServiceId); @endphp
                                <p class="font-bold text-[#f4f4f6] text-sm">{{ $activeS->duracion_minutos }} minutos</p>
                            @else
                                <p class="text-gray-600 text-sm italic">---</p>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="border-t border-[#222227] pt-4 space-y-4">
                    <!-- CLIENTE (SOLO PARA ADMIN) -->
                    @if($isAdmin)
                        <div class="space-y-1.5">
                            <label class="text-sm font-bold text-[#c5a880] block">Paciente</label>
                            <x-wire-native-select
                                wire:model.live="selectedClientId"
                                required
                            >
                                <option value="">
                                    Seleccione un paciente...
                                </option>
                                @foreach($clients as $client)
                                    <option value="{{ $client->id }}">
                                        {{ $client->name }} (ID: {{ $client->id_number ?? 'Sin ID' }})
                                    </option>
                                @endforeach
                            </x-wire-native-select>
                        </div>
                    @endif

                    <!-- Mensajes de Error de Validación -->
                    @if ($errors->any())
                        <div class="bg-red-950/20 text-red-400 p-3.5 rounded-xl border border-red-900/30">
                            <ul class="list-disc list-inside text-xs font-semibold space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Botón de agendar -->
                    <button
                        type="button"
                        wire:click="book"
                        class="w-full bg-gradient-to-r from-[#c5a880] to-[#a2835b] hover:from-[#d4b790] hover:to-[#b2936a] text-black font-black py-4 px-6 rounded-xl transition duration-300 flex items-center justify-center gap-2 shadow-lg shadow-[#c5a880]/10 border-none cursor-pointer transform active:scale-95 disabled:from-gray-800 disabled:to-gray-900 disabled:text-gray-600 disabled:cursor-not-allowed disabled:shadow-none"
                        @if(!$selectedClientId || !$selectedServiceId || !$selectedBarberId || !$selectedDate || !$selectedHour) disabled @endif
                    >
                        <i class="fa-solid fa-calendar-check text-lg"></i>
                        {{ $isAdmin ? 'Confirmar y Crear Cita' : 'Confirmar Reserva' }}
                    </button>
                </div>
            </div>

        </div>

    </div>

</div>
