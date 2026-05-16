<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * LISTADO
     */
    public function index()
    {
        return view('admin.service.index');
    }

    /**
     * FORMULARIO CREATE
     */
    public function create()
    {
        return view('admin.service.create');
    }

    /**
     * GUARDAR SERVICIO
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:100',
            'precio' => 'required|numeric|min:0',
            'duracion_minutos' => 'required|integer|min:10|max:240',
            'descripcion' => 'nullable|string|max:255',
        ]);

        Service::create($data);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Servicio creado',
            'text' => 'El servicio se creó correctamente'
        ]);

        return redirect()->route('admin.service.index');
    }

    /**
     * EDITAR
     */
    public function edit(Service $service)
    {
        return view('admin.service.edit', compact('service'));
    }

    /**
     * ACTUALIZAR
     */
    public function update(Request $request, Service $service)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:100',
            'precio' => 'required|numeric|min:0',
            'duracion_minutos' => 'required|integer|min:10|max:240',
            'descripcion' => 'nullable|string|max:255',
        ]);

        $service->update($data);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Servicio actualizado',
            'text' => 'El servicio se actualizó correctamente'
        ]);

        return redirect()->route('admin.service.edit', $service->id);
    }

    /**
     * ELIMINAR
     */
    public function destroy(Service $service)
    {
        $service->delete();

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Servicio eliminado',
            'text' => 'El servicio se eliminó correctamente'
        ]);

        return redirect()->route('admin.service.index');
    }
}