<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/dashboard', function () {
    return redirect()->route('projects.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Projects
    Route::resource('projects', ProjectController::class);

    // Archives
    Route::get('/projects/archives', [ProjectController::class, 'archives'])
        ->name('projects.archives');

    // Restore
    Route::post('/projects/{project}/restore', [ProjectController::class, 'restore'])
        ->name('projects.restore');

    // Members
    Route::post('/projects/{project}/members', [ProjectController::class, 'addMember'])
        ->name('projects.members.add');

    Route::delete('/projects/{project}/members/{user}', [ProjectController::class, 'removeMember'])
        ->name('projects.members.remove');
});
require __DIR__.'/auth.php';