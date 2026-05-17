<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use SoftDeletes;

    protected $table = 'servicios';

    protected $fillable = [
        'nombre',
        'precio',
        'duracion_minutos',
        'descripcion',
    ];

    // RELACIÓN CON CITAS
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}