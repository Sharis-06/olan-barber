<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreServicioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // El middleware de rutas ya se encarga de la seguridad
    }

    public function rules(): array
    {
        return [
            'nombre' => 'required|string|max:100|unique:servicios,nombre',
            'precio' => 'required|numeric|min:0|max:9999.99',
            'duracion_minutos' => 'required|integer|min:10|max:240', // Mínimo 10 min, máximo 4 horas
            'descripcion' => 'nullable|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre del servicio es obligatorio.',
            'nombre.unique' => 'Este servicio (ej. "Corte de cabello") ya está registrado.',
            'precio.required' => 'Debes asignar un precio al servicio.',
            'precio.numeric' => 'El precio debe ser un número válido.',
            'precio.min' => 'El precio no puede ser un número negativo.',
            'duracion_minutos.required' => 'La duración del servicio es obligatoria.',
            'duracion_minutos.min' => 'La duración mínima debe ser de 10 minutos.',
            
        ];
    }
}
