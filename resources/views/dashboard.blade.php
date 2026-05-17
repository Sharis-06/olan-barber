<x-app-layout>
    @if(auth()->user()->hasRole('Cliente'))
        <div class="space-y-8">
            <!-- Tarjeta de Bienvenida -->
            <div class="bg-gradient-to-r from-gray-800 to-black text-white rounded-2xl p-8 shadow-lg relative overflow-hidden">
                <div class="absolute right-0 bottom-0 opacity-10 transform translate-x-12 translate-y-12 select-none">
                    <i class="fa-solid fa-scissors text-[200px]"></i>
                </div>
                
                <div class="relative z-10 max-w-lg space-y-3">
                    <span class="bg-blue-600/30 text-blue-400 text-xs font-bold uppercase tracking-wider px-3 py-1.5 rounded-full border border-blue-500/20">
                        Cliente de Olan Barber
                    </span>
                    <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">¡Hola, {{ auth()->user()->name }}!</h1>
                    <p class="text-gray-300 text-sm sm:text-base leading-relaxed">
                        Bienvenido a tu panel de control personal. Aquí puedes ver tus próximas reservas de barbería y agendar nuevos servicios al instante.
                    </p>
                    <div class="pt-2">
                        <x-wire-button
                            blue
                            href="{{ route('client.booking') }}"
                            class="shadow-md shadow-blue-800/30 font-bold transition hover:scale-105 border-none"
                        >
                            <i class="fa-solid fa-plus mr-1"></i> Nueva Reserva
                        </x-wire-button>
                    </div>
                </div>
            </div>

            <!-- Sección de Mis Reservas -->
            <div class="space-y-4">
                <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                    <i class="fa-solid fa-calendar-check text-blue-600"></i>
                    Mis Próximas Citas
                </h2>

                @if($appointments->isEmpty())
                    <div class="bg-white border border-gray-100 rounded-2xl p-12 text-center shadow-sm space-y-4">
                        <div class="w-16 h-16 rounded-full bg-gray-50 flex items-center justify-center mx-auto text-gray-400 text-2xl border border-dashed border-gray-200">
                            <i class="fa-solid fa-calendar-xmark"></i>
                        </div>
                        <div class="max-w-md mx-auto space-y-1.5">
                            <h3 class="font-bold text-gray-800 text-lg">No tienes citas agendadas</h3>
                            <p class="text-gray-500 text-sm">
                                ¿Necesitas un corte de pelo o arreglo de barba? ¡Elige a tu barbero preferido y reserva tu turno hoy mismo!
                            </p>
                        </div>
                        <div class="pt-2">
                            <x-wire-button
                                outline
                                blue
                                href="{{ route('client.booking') }}"
                            >
                                Reservar ahora
                            </x-wire-button>
                        </div>
                    </div>
                @else
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-gray-50/50 border-b border-gray-100 text-gray-400 text-xs font-bold uppercase">
                                        <th class="p-4 pl-6">Servicio</th>
                                        <th class="p-4">Barbero</th>
                                        <th class="p-4">Fecha</th>
                                        <th class="p-4">Hora</th>
                                        <th class="p-4">Precio</th>
                                        <th class="p-4 pr-6 text-center">Estado</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 text-sm">
                                    @foreach($appointments as $appointment)
                                        <tr class="hover:bg-gray-50/30 transition-colors">
                                            <td class="p-4 pl-6 font-semibold text-gray-800">
                                                {{ $appointment->service->nombre }}
                                            </td>
                                            <td class="p-4 text-gray-600 font-semibold">
                                                {{ $appointment->barber->name }}
                                            </td>
                                            <td class="p-4 text-gray-600 font-medium">
                                                {{ \Carbon\Carbon::parse($appointment->fecha)->translatedFormat('d \d\e M, Y') }}
                                            </td>
                                            <td class="p-4 text-gray-600 font-bold">
                                                {{ \Carbon\Carbon::parse($appointment->hora)->format('H:i') }}
                                            </td>
                                            <td class="p-4 text-blue-600 font-bold">
                                                ${{ number_format($appointment->service->precio, 2) }}
                                            </td>
                                            <td class="p-4 pr-6 text-center">
                                                @if($appointment->estado === 'pendiente')
                                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-600 border border-amber-200">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                                        Pendiente
                                                    </span>
                                                @elseif($appointment->estado === 'confirmada')
                                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-600 border border-blue-200">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                                        Confirmada
                                                    </span>
                                                @elseif($appointment->estado === 'completada')
                                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-600 border border-emerald-200">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                                        Completada
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-red-50 text-red-600 border border-red-200">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                                        Cancelada
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @else
        <!-- Contenido por defecto para administradores en el dashboard -->
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <h1 class="text-2xl font-bold text-gray-800">Bienvenido al Panel de Administración</h1>
                    <p class="text-gray-500 mt-2">Utiliza la barra lateral para gestionar los servicios, barberos, citas, roles y usuarios.</p>
                </div>
            </div>
        </div>
    @endif
</x-app-layout>
