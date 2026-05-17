<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAppointmentRequest;
use App\Models\Appointment;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.appointments.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // CLIENTS
        $clients = User::role('Cliente')->get();

        // BARBERS
        $barbers = User::role('Barbero')->get();

        // SERVICES
        $services = Service::all();

        return view('admin.appointments.create', compact(
            'clients',
            'barbers',
            'services'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAppointmentRequest $request)
    {
        Appointment::create($request->validated());

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Cita creada',
            'text' => 'La cita ha sido creada correctamente.'
        ]);

        return redirect()->route('admin.appointments.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Appointment $appointment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Appointment $appointment)
    {
        $clients = User::role('Cliente')->get();

        $barbers = User::role('Barbero')->get();

        $services = Service::all();

        return view('admin.appointments.edit', compact(
            'appointment',
            'clients',
            'barbers',
            'services'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Appointment $appointment)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',

            'barber_id' => 'required|exists:users,id',

            'service_id' => 'required|exists:servicios,id',

            'fecha' => 'required|date|after_or_equal:today',

            'hora' => [
                'required',
                function ($attribute, $value, $fail) use ($request, $appointment) {
                    $exists = Appointment::where('barber_id', $request->barber_id)
                        ->where('fecha', $request->fecha)
                        ->where('hora', $value)
                        ->where('id', '!=', $appointment->id)
                        ->exists();

                    if ($exists) {
                        $fail('El barbero seleccionado ya tiene una cita agendada en esa fecha y hora.');
                    }
                }
            ],

            'estado' => 'required|in:pendiente,confirmada,completada,cancelada',
        ]);

        $appointment->update($data);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Cita actualizada',
            'text' => 'La cita ha sido actualizada correctamente.'
        ]);

        return redirect()->route('admin.appointments.edit', $appointment);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Cita eliminada',
            'text' => 'La cita ha sido eliminada correctamente.'
        ]);

        return redirect()->route('admin.appointments.index');
    }
}