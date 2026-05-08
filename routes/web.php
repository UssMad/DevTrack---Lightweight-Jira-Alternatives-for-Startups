<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $user = auth()->user();
    $projects = $user->projects()->with('tasks', 'users')->get();
    $allTasks = \App\Models\Task::whereIn('project_id', $projects->pluck('id'))->with('project', 'user')->latest()->get();
    return view('dashboard', compact('projects', 'allTasks'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Archives (must be before resource route)
    Route::get('/projects/archives', [ProjectController::class, 'archives'])
        ->name('projects.archives');

    // Projects
    Route::resource('projects', ProjectController::class);

    // Restore
    Route::post('/projects/{project}/restore', [ProjectController::class, 'restore'])
        ->name('projects.restore');

    // Force Delete
    Route::delete('/projects/{project}/force-delete', [ProjectController::class, 'forceDelete'])
        ->name('projects.forceDelete');

    // Members
    Route::post('/projects/{project}/members', [ProjectController::class, 'addMember'])
        ->name('projects.members.add');

    Route::delete('/projects/{project}/members/{user}', [ProjectController::class, 'removeMember'])
        ->name('projects.members.remove');

    // Team
    Route::get('/team', [TeamController::class, 'index'])->name('team.index');

    // Tasks
    Route::resource('tasks', TaskController::class);
    Route::patch('/tasks/{task}/status', [TaskController::class, 'updateStatus'])
        ->name('tasks.updateStatus');
});

require __DIR__.'/auth.php';