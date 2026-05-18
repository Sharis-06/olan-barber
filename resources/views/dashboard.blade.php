<x-app-layout>
    @if(auth()->user()->hasRole('Cliente'))
        <div class="space-y-8">
            <!-- Tarjeta de Bienvenida -->
            <div class="bg-gradient-to-r from-[#18181b] to-[#0c0c0e] border border-[#222227] text-[#f4f4f6] rounded-2xl p-8 shadow-2xl relative overflow-hidden">
                <div class="absolute right-0 bottom-0 opacity-5 transform translate-x-12 translate-y-12 select-none pointer-events-none">
                    <i class="fa-solid fa-scissors text-[200px] text-[#c5a880]"></i>
                </div>
                
                <div class="relative z-10 max-w-lg space-y-3">
                    <span class="bg-[#c5a880]/15 text-[#c5a880] text-[10px] font-black uppercase tracking-[0.2em] px-3.5 py-1.5 rounded-full border border-[#c5a880]/20">
                        Cliente Distinguido
                    </span>
                    <h1 class="text-3xl sm:text-4xl font-black tracking-tight mt-2 text-[#f4f4f6]">¡Hola, {{ auth()->user()->name }}!</h1>
                    <p class="text-gray-400 text-sm sm:text-base leading-relaxed font-medium">
                        Bienvenido a tu panel de control personal. Aquí puedes ver tus próximas reservas de barbería y agendar nuevos servicios al instante.
                    </p>
                    <div class="pt-3">
                        <a
                            href="{{ route('client.booking') }}"
                            class="inline-flex items-center gap-2 bg-gradient-to-r from-[#c5a880] to-[#a2835b] hover:from-[#d4b790] hover:to-[#b2936a] text-black font-extrabold px-6 py-3 rounded-xl transition duration-300 transform hover:scale-105 shadow-lg shadow-[#c5a880]/10 border-none cursor-pointer"
                        >
                            <i class="fa-solid fa-plus text-sm"></i> Nueva Reserva
                        </a>
                    </div>
                </div>
            </div>

            <!-- Sección de Mis Reservas -->
            <div class="space-y-4">
                <h2 class="text-xl font-black text-[#f4f4f6] flex items-center gap-2">
                    <i class="fa-solid fa-calendar-check text-[#c5a880]"></i>
                    Mis Próximas Citas
                </h2>

                @if($appointments->isEmpty())
                    <div class="bg-[#121215] border border-[#222227] rounded-2xl p-12 text-center shadow-xl space-y-4">
                        <div class="w-16 h-16 rounded-full bg-[#1a1a1f] flex items-center justify-center mx-auto text-[#c5a880] text-2xl border border-dashed border-[#222227]">
                            <i class="fa-solid fa-calendar-xmark"></i>
                        </div>
                        <div class="max-w-md mx-auto space-y-1.5">
                            <h3 class="font-bold text-[#f4f4f6] text-lg">No tienes citas agendadas</h3>
                            <p class="text-gray-400 text-sm font-medium">
                                ¿Necesitas un corte de pelo o arreglo de barba? ¡Elige a tu barbero preferido y reserva tu turno hoy mismo!
                            </p>
                        </div>
                        <div class="pt-3">
                            <a
                                href="{{ route('client.booking') }}"
                                class="inline-flex items-center gap-2 bg-[#1a1a1f] hover:bg-[#222227] text-[#c5a880] border border-[#c5a880] font-extrabold px-5 py-2.5 rounded-xl transition duration-300 cursor-pointer"
                            >
                                Reservar ahora
                            </a>
                        </div>
                    </div>
                @else
                    <div class="bg-[#121215] rounded-2xl shadow-2xl border border-[#222227] overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-[#1a1a1f] border-b border-[#222227] text-[#c5a880] text-xs font-black tracking-widest uppercase">
                                        <th class="p-4 pl-6">Servicio</th>
                                        <th class="p-4">Barbero</th>
                                        <th class="p-4">Fecha</th>
                                        <th class="p-4">Hora</th>
                                        <th class="p-4">Precio</th>
                                        <th class="p-4 pr-6 text-center">Estado</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-[#222227]/40 text-sm">
                                    @foreach($appointments as $appointment)
                                        <tr class="hover:bg-[#1a1a1f]/40 transition-colors">
                                            <td class="p-4 pl-6 font-bold text-[#f4f4f6]">
                                                {{ $appointment->service->nombre }}
                                            </td>
                                            <td class="p-4 text-gray-300 font-semibold">
                                                {{ $appointment->barber->name }}
                                            </td>
                                            <td class="p-4 text-gray-400 font-medium">
                                                {{ \Carbon\Carbon::parse($appointment->fecha)->translatedFormat('d \d\e M, Y') }}
                                            </td>
                                            <td class="p-4 text-[#f4f4f6] font-extrabold">
                                                {{ \Carbon\Carbon::parse($appointment->hora)->format('H:i') }}
                                            </td>
                                            <td class="p-4 text-[#c5a880] font-black">
                                                ${{ number_format($appointment->service->precio, 2) }}
                                            </td>
                                            <td class="p-4 pr-6 text-center">
                                                @if($appointment->estado === 'pendiente')
                                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-amber-950/20 text-amber-400 border border-amber-900/30">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                                        Pendiente
                                                    </span>
                                                @elseif($appointment->estado === 'confirmada')
                                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-indigo-950/20 text-indigo-400 border border-indigo-900/30">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-indigo-500"></span>
                                                        Confirmada
                                                    </span>
                                                @elseif($appointment->estado === 'completada')
                                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-950/20 text-emerald-400 border border-emerald-900/30">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                                        Completada
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-red-950/20 text-red-400 border border-red-900/30">
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
                <div class="bg-[#121215] overflow-hidden shadow-2xl border border-[#222227] rounded-2xl p-8 relative">
                    <div class="absolute right-0 bottom-0 opacity-[0.03] transform translate-x-12 translate-y-12 select-none pointer-events-none">
                        <i class="fa-solid fa-scissors text-[250px] text-[#c5a880]"></i>
                    </div>

                    <h1 class="text-3xl font-black text-[#f4f4f6] flex items-center gap-2">
                        <i class="fa-solid fa-toolbox text-[#c5a880]"></i>
                        Panel de Administración
                    </h1>
                    <p class="text-gray-400 mt-3 text-base leading-relaxed font-medium">
                        Bienvenido de vuelta, {{ auth()->user()->name }}. Utiliza el menú lateral para gestionar eficientemente los servicios, barberos, citas agendadas, roles de acceso y perfiles de usuarios de **Olan Barbershop**.
                    </p>
                </div>
            </div>
        </div>
    @endif
</x-app-layout>
