<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TaskController;

Route::get('tasks/trash', [TaskController::class, 'trash'])->name('tasks.trash');
Route::post('tasks/{id}/restore', [TaskController::class, 'restore'])->name('tasks.restore');
Route::delete('tasks/{id}/force-delete', [TaskController::class, 'forceDelete'])
     ->name('tasks.forceDelete');
     
Route::resource('tasks', TaskController::class);
