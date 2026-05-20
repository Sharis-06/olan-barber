<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\AppointmentNotification;

class Appointment extends Model
{
    use SoftDeletes;

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

                // 1. Send the confirmation email to the client
                if ($appointment->user && $appointment->user->email) {
                    Mail::to($appointment->user->email)
                        ->send(new AppointmentNotification($appointment));
                }

                // 2. Send a copy to the assigned barber
                if ($appointment->barber && $appointment->barber->email) {
                    Mail::to($appointment->barber->email)
                        ->send(new AppointmentNotification($appointment));
                }

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