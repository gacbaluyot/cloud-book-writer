<?php

use App\Http\Controllers\Author\AuthorController;
use App\Http\Controllers\Author\BookController;
use App\Http\Controllers\SectionController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth', 'role:Author'])->group(function () {
    Route::get('/author/dashboard', [AuthorController::class, 'dashboard'])->name('author.dashboard');
    // Add other author-specific routes here
    Route::resource('book', BookController::class);

    Route::post('/books/{book}/assign-role', [BookController::class, 'assignRoleToUser'])->name('assign.collaborator');
    Route::delete('/book/{book}/collaborator/{user}', [BookController::class, 'removeCollaborator'])->name(
        'remove.collaborator'
    );

    Route::get('/sections-for-book/{book}', [SectionController::class, 'getSectionsForBook'])->name('sections.forBook');

    // Sections resource split
    Route::get('/sections', [SectionController::class, 'index'])->name('sections.index');
    Route::get('/sections/create', [SectionController::class, 'create'])->name('sections.create');
    Route::post('/sections', [SectionController::class, 'store'])->name('sections.store');
    Route::get('/sections/{section}', [SectionController::class, 'show'])->name('sections.show');
    Route::delete('/sections/{section}', [SectionController::class, 'destroy'])->name('sections.destroy');
});

// Routes for edit and update with additional role check
Route::middleware(['auth', 'role:Collaborator,Author'])->group(function () {
    Route::get('/sections/{section}/edit', [SectionController::class, 'edit'])->name('sections.edit');
    Route::put('/sections/{section}', [SectionController::class, 'update'])->name('sections.update');
});

