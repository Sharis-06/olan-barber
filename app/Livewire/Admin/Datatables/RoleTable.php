<?php

namespace App\Livewire\Admin\Datatables;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Spatie\Permission\Models\Role;

class RoleTable extends DataTableComponent
{
    protected $model = Role::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setSearchPlaceholder('Buscar');
        
        // Configuración de la tabla para que coincida con el diseño
        $this->setTableAttributes([
            'class' => 'min-w-full divide-y divide-gray-200',
        ]);

        $this->setTheadAttributes([
            'class' => 'bg-gray-50',
        ]);

        $this->setThAttributes(function(Column $column) {
            return [
                'class' => 'px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider',
            ];
        });

        $this->setTrAttributes(function($row, $index) {
            return [
                'class' => 'border-b border-gray-100 hover:bg-gray-50 transition-colors',
            ];
        });
        
        $this->setTdAttributes(function(Column $column, $row, $index, $cellValue) {
            return [
                'class' => 'px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900',
            ];
        });
    }

    public function columns(): array
    {
        return [
            Column::make("ID", "id")
                ->sortable(),
            Column::make("NOMBRE", "name")
                ->sortable()
                ->searchable(),
            Column::make("FECHA", "created_at")
                ->sortable()
                ->format(fn($value) => $value->format('d/m/Y')),
            Column::make("ACCIONES")
                ->label(fn($row) => view('admin.roles.actions', ['role' => $row]))
        ];
    }
}
