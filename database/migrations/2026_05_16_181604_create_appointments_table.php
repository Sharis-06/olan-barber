<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {

            $table->id();

            // CLIENTE
            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');

            // BARBERO
            $table->foreignId('barber_id')
                ->constrained('users')
                ->onDelete('cascade');

            // SERVICIO
            $table->foreignId('service_id')
                ->constrained('servicios')
                ->onDelete('cascade');

            // FECHA
            $table->date('fecha');

            // HORA
            $table->time('hora');

            // ESTADO
            $table->enum('estado', [
                'pendiente',
                'confirmada',
                'completada',
                'cancelada'
            ])->default('pendiente');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};