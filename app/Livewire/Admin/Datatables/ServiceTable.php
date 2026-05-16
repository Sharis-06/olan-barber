<?php

namespace App\Livewire\Admin\Datatables;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Service;
use Illuminate\Database\Eloquent\Builder;

class ServiceTable extends DataTableComponent
{
    // Modelo base del datatable
    public function builder(): Builder
    {
        return Service::query();
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),

            Column::make("Nombre", "nombre")
                ->sortable()
                ->searchable(),

            Column::make("Precio", "precio")
                ->sortable()
                ->format(fn($value) => '$' . number_format($value, 2)),

            Column::make("Duración (min)", "duracion_minutos")
                ->sortable(),

            Column::make("Descripción", "descripcion")
                ->sortable()
                ->searchable(),

            Column::make("Acciones")
                ->label(function ($row) {
                    return view('admin.service.actions', [
                        'service' => $row
                    ]);
                }),
        ];
    }
}