<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

// Redirigir la ruta raíz a la lista de tareas
Route::get('/', [TaskController::class, 'index']);

Route::resource('tasks', TaskController::class);
