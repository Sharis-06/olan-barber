<div>
    <x-wire-card>
        <div class="mb-6">
            <h2 class="text-xl font-bold text-gray-200 mb-2">Configuración de Horario Semanal</h2>
            <p class="text-sm text-gray-400">Define los días que trabajas y tus horas de entrada y salida. Los turnos no pueden exceder las 8 horas diarias.</p>
        </div>

        @if(auth()->user()->hasAnyRole(['Administrador', 'Super Administrador']))
            <div class="mb-6">
                <x-wire-native-select
                    label="Selecciona un Barbero"
                    wire:model.live="barber_id"
                >
                    <option value="">Selecciona un barbero...</option>
                    @foreach($barbers as $barber)
                        <option value="{{ $barber->id }}">{{ $barber->name }}</option>
                    @endforeach
                </x-wire-native-select>
            </div>
        @endif

        <form wire:submit="save">
            <div class="space-y-4">
                @foreach($daysOfWeek as $index => $dayName)
                    <div class="bg-[#1a1a1f] p-4 rounded-xl border border-[#222227] flex flex-col md:flex-row md:items-center justify-between gap-4">
                        
                        <div class="flex items-center gap-4 min-w-[200px]">
                            <x-wire-toggle 
                                wire:model.live="schedules.{{ $index }}.is_working" 
                                label="{{ $dayName }}"
                                lg
                            />
                        </div>

                        @if($schedules[$index]['is_working'])
                            <div class="flex items-center gap-4 flex-1">
                                <div class="flex-1">
                                    <x-wire-input 
                                        type="time" 
                                        label="Hora de Entrada" 
                                        wire:model="schedules.{{ $index }}.start_time"
                                        required 
                                    />
                                    @error("schedules.{$index}.start_time")
                                        <span class="text-red-500 text-xs font-bold block mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="flex-1">
                                    <x-wire-input 
                                        type="time" 
                                        label="Hora de Salida" 
                                        wire:model="schedules.{{ $index }}.end_time"
                                        required 
                                    />
                                </div>
                            </div>
                            
                            @error("schedules.{$index}.end_time")
                                <span class="text-red-500 text-xs font-bold block mt-1">{{ $message }}</span>
                            @enderror
                        @else
                            <div class="flex-1 text-gray-500 text-sm font-semibold italic flex items-center justify-center bg-[#121215] rounded-lg py-2 border border-[#222227] opacity-60">
                                Día de descanso
                            </div>
                        @endif

                    </div>
                @endforeach
            </div>

            <div class="mt-8 flex justify-end">
                <x-wire-button type="submit" blue class="w-full md:w-auto" lg>
                    <i class="fa-solid fa-save mr-2"></i> Guardar Horario
                </x-wire-button>
            </div>
        </form>
    </x-wire-card>
</div>
