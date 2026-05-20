<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Spatie\Permission\Traits\HasRoles;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// IMPORTANTE
use App\Models\Appointment;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'id_number',
        'phone',
        'address',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relación con citas (appointments)
    // CITAS COMO CLIENTE
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    // CITAS COMO BARBERO
    public function barberAppointments()
    {
        return $this->hasMany(Appointment::class, 'barber_id');
    }

    // HORARIOS COMO BARBERO
    public function schedules()
    {
        return $this->hasMany(BarberSchedule::class, 'barber_id');
    }
}