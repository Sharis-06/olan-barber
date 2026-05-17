<?php

namespace App\Livewire\Admin\Datatables;

use App\Models\Appointment;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class AppointmentTable extends DataTableComponent
{
    public function builder(): Builder
    {
        return Appointment::query()
        ->with([
            'user',
            'barber',
            'service'
        ]);
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [

            Column::make("ID", "id")
                ->sortable(),

            Column::make("Cliente", "user.name")
                ->sortable()
                ->searchable(),

            Column::make("Barbero", "barber.name")
                ->sortable()
                ->searchable(),

            Column::make("Servicio", "service.nombre")
                ->sortable()
                ->searchable(),

            Column::make("Fecha", "fecha")
                ->sortable(),

            Column::make("Hora", "hora")
                ->sortable(),

            Column::make("Estado", "estado")
                ->sortable(),

            Column::make("Acciones")
                ->label(function ($row) {
                    return view('admin.appointments.actions', [
                        'appointment' => $row
                    ]);
                }),
        ];
    }
}