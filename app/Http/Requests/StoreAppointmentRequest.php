<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreAppointmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
            'barber_id' => 'required|exists:users,id',
            'service_id' => 'required|exists:servicios,id',
            'fecha' => 'required|date|after_or_equal:today',
            'hora' => [
                'required',
                function ($attribute, $value, $fail) {
                    $exists = \App\Models\Appointment::where('barber_id', $this->barber_id)
                        ->where('fecha', $this->fecha)
                        ->where('hora', $value)
                        ->exists();

                    if ($exists) {
                        $fail('El barbero seleccionado ya tiene una cita agendada en esa fecha y hora.');
                    }
                }
            ],
            'estado' => 'required'
        ];
    }
}
