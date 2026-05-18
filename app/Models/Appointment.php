<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\AppointmentNotification;

class Appointment extends Model
{
    protected $fillable = [
        'user_id',
        'barber_id',
        'service_id',
        'fecha',
        'hora',
        'estado',
    ];

    /**
     * El "booted" method del modelo.
     */
    protected static function booted()
    {
        static::created(function ($appointment) {
            try {
                // Eager load relations for the email template
                $appointment->load(['user', 'service', 'barber']);

                // Send the confirmation email
                Mail::to($appointment->user->email)
                    ->send(new AppointmentNotification($appointment));
            } catch (\Exception $e) {
                // Log error instead of throwing exception to prevent app from crashing when offline
                Log::error("Error enviando correo de confirmación de cita #" . $appointment->id . ": " . $e->getMessage());
            }
        });
    }

    // CLIENTE
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // BARBERO
    public function barber()
    {
        return $this->belongsTo(User::class, 'barber_id');
    }

    // SERVICIO
    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }
}