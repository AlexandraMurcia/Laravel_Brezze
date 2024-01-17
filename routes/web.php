<?php

// Importa las clases y namespaces necesarios
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\FormController;
use App\Http\Controllers\PDFController; 

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Aquí es donde puedes registrar rutas web para tu aplicación. Estas rutas
| son cargadas por RouteServiceProvider dentro de un grupo que contiene el
| middleware "web". Ahora crea algo grandioso.
|
*/

// Ruta principal que renderiza la vista 'Welcome' utilizando Inertia
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// Ruta para el dashboard que renderiza la vista 'Dashboard'
Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Grupo de rutas protegidas por el middleware de autenticación
Route::middleware('auth')->group(function () {
    // Rutas para el perfil de usuario (editar, actualizar y eliminar)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Ruta para manejar la solicitud de formulario enviado mediante POST
Route::post('/submit-form', [FormController::class, 'submitForm']);

// Ruta para generar un archivo PDF
Route::get('create-pdf-file', [PDFController::class, 'index']);

// Incluye las rutas de autenticación proporcionadas por Laravel
require __DIR__.'/auth.php';

