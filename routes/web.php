<?php
use App\Http\Controllers\Admin\AppointmentController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\ProfileController;
use App\Livewire\Admin\BarberScheduleManager;
use App\Livewire\ClientBooking;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $user = auth()->user();
    $appointments = collect();
    if ($user && $user->hasRole('Cliente')) {
        $appointments = $user->appointments()->with(['barber', 'service'])->latest()->get();
    }
    return view('dashboard', compact('appointments'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/booking', ClientBooking::class)->name('client.booking');

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

Route::middleware(['auth', 'role:Administrador|Super Administrador|Barbero'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // --- RUTAS COMPARTIDAS (Admin y Barbero) ---
        Route::get('/dashboard', function () {
            return view('dashboard');
        })->name('dashboard');

        // RUTA DE CITAS
        Route::get('appointments/{appointment}/pdf', [AppointmentController::class, 'downloadPdf'])
            ->name('appointments.pdf');
        Route::resource('appointments', AppointmentController::class);

        // RUTA DE HORARIOS DE BARBEROS
        Route::get('/schedules', BarberScheduleManager::class)->name('schedules.index');

        // --- RUTAS EXCLUSIVAS DE ADMINISTRACIÓN ---
        Route::middleware(['role:Administrador|Super Administrador'])->group(function () {
            // RUTA DE ROLES
            Route::resource('roles', RoleController::class);
            // RUTA DE USUARIOS 
            Route::resource('users', UserController::class);
            // RUTA DE SERVCIOS 
            Route::resource('service', ServiceController::class);
        });

});

require __DIR__.'/auth.php';