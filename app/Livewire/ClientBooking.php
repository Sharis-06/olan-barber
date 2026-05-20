<?php

namespace App\Livewire;

use App\Models\Appointment;
use App\Models\Service;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;

class ClientBooking extends Component
{
    public $clients;
    public $services;
    public $barbers;

    // Selected state
    public $selectedClientId = null;
    public $selectedServiceId = null;
    public $selectedBarberId = null;
    public $selectedDate = null;
    public $selectedHour = null;



    public function mount()
    {
        $user = auth()->user();
        $this->services = Service::all();
        $this->barbers = User::role('Barbero')->orderBy('name')->get();
        $this->selectedDate = Carbon::today()->format('Y-m-d');

        // Set default service if available
        if ($this->services->isNotEmpty()) {
            $this->selectedServiceId = $this->services->first()->id;
        }

        // If admin/staff, load clients
        if ($user && $user->hasAnyRole(['Administrador', 'Super Administrador', 'Recepcionista'])) {
            $this->clients = User::role('Cliente')->orderBy('name')->get();
        } else {
            $this->clients = collect();
            $this->selectedClientId = $user->id; // Defaults to self
        }
    }

    public function selectBarberAndHour($barberId, $hour)
    {
        $this->selectedBarberId = $barberId;
        $this->selectedHour = $hour;
    }

    public function updatedSelectedDate()
    {
        // Reset slot selection when date changes to prevent booking invalid hours
        $this->selectedHour = null;
        $this->selectedBarberId = null;
    }

    public function updatedSelectedServiceId()
    {
        $this->selectedHour = null;
        $this->selectedBarberId = null;
    }

    private function getWorkingHoursForBarber($barberId, $date)
    {
        if (!$date) return [];
        
        $dayOfWeek = Carbon::parse($date)->dayOfWeek;
        
        $schedule = \App\Models\BarberSchedule::where('barber_id', $barberId)
            ->where('day_of_week', $dayOfWeek)
            ->first();

        if (!$schedule || !$schedule->is_working) {
            return [];
        }

        $start = Carbon::parse($schedule->start_time);
        $end = Carbon::parse($schedule->end_time);
        $hours = [];

        while ($start < $end) {
            $hours[] = $start->format('H:i');
            $start->addHour();
        }

        return $hours;
    }

    // Direct dynamic method to fetch slot availability for a specific barber on selected date
    public function getAvailableHoursForBarber($barberId)
    {
        if (!$this->selectedDate) {
            return [];
        }

        $workingHours = $this->getWorkingHoursForBarber($barberId, $this->selectedDate);

        if (empty($workingHours)) {
            return [];
        }

        // Get occupied slots on selected date for this barber
        $occupiedHours = Appointment::where('barber_id', $barberId)
            ->where('fecha', $this->selectedDate)
            ->whereIn('estado', ['pendiente', 'confirmada', 'completada'])
            ->pluck('hora')
            ->map(function ($time) {
                return Carbon::parse($time)->format('H:i');
            })
            ->toArray();

        $available = [];
        foreach ($workingHours as $hour) {
            $isPast = false;
            if ($this->selectedDate === Carbon::today()->format('Y-m-d')) {
                $slotTime = Carbon::parse($this->selectedDate . ' ' . $hour);
                if ($slotTime->isPast()) {
                    $isPast = true;
                }
            }

            $available[] = [
                'time' => $hour,
                'available' => !in_array($hour, $occupiedHours) && !$isPast
            ];
        }

        return $available;
    }

    public function book()
    {
        $isAdmin = auth()->user()->hasAnyRole(['Administrador', 'Super Administrador', 'Recepcionista']);

        $validHours = [];
        if ($this->selectedBarberId && $this->selectedDate) {
            $validHours = $this->getWorkingHoursForBarber($this->selectedBarberId, $this->selectedDate);
        }

        $this->validate([
            'selectedClientId' => 'required|exists:users,id',
            'selectedServiceId' => 'required|exists:servicios,id',
            'selectedBarberId' => 'required|exists:users,id',
            'selectedDate' => 'required|date|after_or_equal:today',
            'selectedHour' => 'required|in:' . implode(',', $validHours),
        ], [
            'selectedClientId.required' => 'Por favor, selecciona un cliente.',
            'selectedServiceId.required' => 'Por favor, selecciona un servicio.',
            'selectedBarberId.required' => 'Por favor, selecciona un barbero.',
            'selectedDate.required' => 'Por favor, selecciona una fecha.',
            'selectedHour.required' => 'Por favor, selecciona una hora para la cita.',
            'selectedHour.in' => 'El horario seleccionado no es válido o el barbero no está disponible.',
        ]);

        // Double check conflict prevention
        $exists = Appointment::where('barber_id', $this->selectedBarberId)
            ->where('fecha', $this->selectedDate)
            ->where('hora', $this->selectedHour)
            ->exists();

        if ($exists) {
            $this->addError('selectedHour', 'Lo sentimos, este horario acaba de ser ocupado. Por favor, selecciona otro.');
            return;
        }

        // Save appointment
        Appointment::create([
            'user_id' => $this->selectedClientId,
            'barber_id' => $this->selectedBarberId,
            'service_id' => $this->selectedServiceId,
            'fecha' => $this->selectedDate,
            'hora' => $this->selectedHour,
            'estado' => $isAdmin ? 'confirmada' : 'pendiente',
        ]);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => $isAdmin ? '¡Cita Creada!' : '¡Cita Reservada!',
            'text' => $isAdmin ? 'La cita ha sido agendada con éxito para el cliente.' : 'Tu cita ha sido agendada con éxito. ¡Te esperamos!',
            'confirmButtonText' => 'Aceptar'
        ]);

        if ($isAdmin) {
            return redirect()->route('admin.appointments.index');
        }

        return redirect()->route('dashboard');
    }

    public function render()
    {
        $isAdmin = auth()->user()->hasAnyRole(['Administrador', 'Super Administrador', 'Recepcionista']);

        return view('livewire.client-booking')
            ->layout($isAdmin ? 'layouts.admin' : 'layouts.app', [
                'title' => $isAdmin ? 'Nueva Cita' : 'Reservar Cita',
                'breadcrumbs' => $isAdmin ? [
                    ['name' => 'Dashboard', 'href' => route('admin.dashboard')],
                    ['name' => 'Citas', 'href' => route('admin.appointments.index')],
                    ['name' => 'Nueva Cita']
                ] : [
                    ['name' => 'Dashboard', 'href' => route('dashboard')],
                    ['name' => 'Reservar Cita']
                ]
            ]);
    }
}
