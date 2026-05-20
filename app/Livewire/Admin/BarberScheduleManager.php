<?php

namespace App\Livewire\Admin;

use App\Models\BarberSchedule;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;

class BarberScheduleManager extends Component
{
    public $barber_id;
    public $barbers = [];
    public $schedules = [];

    public $daysOfWeek = [
        0 => 'Domingo',
        1 => 'Lunes',
        2 => 'Martes',
        3 => 'Miércoles',
        4 => 'Jueves',
        5 => 'Viernes',
        6 => 'Sábado',
    ];

    public function mount()
    {
        $user = auth()->user();

        if ($user->hasAnyRole(['Administrador', 'Super Administrador'])) {
            $this->barbers = User::role('Barbero')->get();
            // Default to first barber if any
            if ($this->barbers->isNotEmpty()) {
                $this->barber_id = $this->barbers->first()->id;
            }
        } else {
            // It's a barber
            $this->barber_id = $user->id;
        }

        $this->loadSchedules();
    }

    public function updatedBarberId()
    {
        $this->loadSchedules();
    }

    public function loadSchedules()
    {
        $existingSchedules = collect();
        
        if ($this->barber_id) {
            $existingSchedules = BarberSchedule::where('barber_id', $this->barber_id)
                ->get()
                ->keyBy('day_of_week');
        }

        $this->schedules = [];

        foreach ($this->daysOfWeek as $index => $name) {
            if ($existingSchedules->has($index)) {
                $schedule = $existingSchedules->get($index);
                $this->schedules[$index] = [
                    'is_working' => $schedule->is_working,
                    'start_time' => Carbon::parse($schedule->start_time)->format('H:i'),
                    'end_time' => Carbon::parse($schedule->end_time)->format('H:i'),
                ];
            } else {
                // Default schedule
                $this->schedules[$index] = [
                    'is_working' => false,
                    'start_time' => '09:00',
                    'end_time' => '17:00',
                ];
            }
        }
    }

    public function save()
    {
        $this->validate([
            'barber_id' => 'required|exists:users,id',
        ]);

        foreach ($this->schedules as $day => $data) {
            $isWorking = filter_var($data['is_working'], FILTER_VALIDATE_BOOLEAN);

            if ($isWorking) {
                if (empty($data['start_time'])) {
                    $this->addError("schedules.$day.start_time", "Requerido.");
                    return;
                }
                if (empty($data['end_time'])) {
                    $this->addError("schedules.$day.end_time", "Requerido.");
                    return;
                }

                $start = Carbon::parse($data['start_time']);
                $end = Carbon::parse($data['end_time']);
                
                // Validate 8 hours diff (optional strictness, but we will check it)
                if ($start->diffInHours($end) > 8) {
                    $this->addError("schedules.$day.end_time", "Máximo 8 hrs.");
                    return;
                }
            }

            BarberSchedule::updateOrCreate(
                ['barber_id' => $this->barber_id, 'day_of_week' => $day],
                [
                    'is_working' => $isWorking,
                    'start_time' => $isWorking ? $data['start_time'] : null,
                    'end_time' => $isWorking ? $data['end_time'] : null,
                ]
            );
        }

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Horarios actualizados',
            'text' => 'El horario del barbero se ha guardado correctamente.',
            'confirmButtonText' => 'Aceptar'
        ]);

        return redirect()->route('admin.schedules.index');
    }

    public function render()
    {
        return view('livewire.admin.barber-schedule-manager')
            ->layout('layouts.admin', [
                'title' => 'Mis Horarios',
                'breadcrumbs' => [
                    ['name' => 'Dashboard', 'href' => route('admin.dashboard')],
                    ['name' => 'Horarios'],
                ]
            ]);
    }
}
