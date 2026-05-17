<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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