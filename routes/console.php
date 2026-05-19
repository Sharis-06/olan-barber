<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Models\Appointment;
use App\Mail\AppointmentReminderNotification;
use Carbon\Carbon;

// 1. Comando Artisan Personalizado para Envío Manual y Pruebas
Artisan::command('appointments:send-reminders', function () {
    $this->info("=== Iniciando Envío de Recordatorios ===");
    
    $tomorrow = Carbon::tomorrow('America/Merida')->toDateString();
    $this->comment("Buscando citas para mañana (Zona Horaria Local): " . $tomorrow);

    $appointments = Appointment::with(['user', 'service', 'barber'])
        ->where('fecha', $tomorrow)
        ->whereIn('estado', ['pendiente', 'confirmada'])
        ->get();

    $this->info("Se encontraron " . $appointments->count() . " citas para mañana.");

    foreach ($appointments as $appointment) {
        if ($appointment->user && $appointment->user->email) {
            try {
                $this->comment("Enviando recordatorio a: " . $appointment->user->email . " (Cita #" . $appointment->id . ")...");
                
                Mail::to($appointment->user->email)
                    ->send(new AppointmentReminderNotification($appointment));
                
                $this->info("✅ Recordatorio enviado con éxito para la cita #" . $appointment->id);
            } catch (\Exception $e) {
                $this->error("❌ Error en cita #" . $appointment->id . ": " . $e->getMessage());
            }
        }
    }
    
    $this->info("=== Proceso Completado ===");
})->purpose('Enviar recordatorios de citas de mañana de forma manual');

// 2. Programar la ejecución automática diaria de este comando a las 08:00 AM
Schedule::command('appointments:send-reminders')->dailyAt('08:00');
