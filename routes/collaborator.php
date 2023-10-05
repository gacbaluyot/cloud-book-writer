<?php

use App\Http\Controllers\Collaborator\CollaboratorController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [CollaboratorController::class, 'dashboard'])->name('collaborator.dashboard');
    Route::get('/book/edit/{book}', [CollaboratorController::class, 'edit'])->name('collaborator.edit');
});
