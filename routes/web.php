<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $user = auth()->user();
    $totalTasks = $user->tasks()->count();
    $completedTasks = $user->tasks()->where('status', 'completed')->count();
    $inProgressTasks = $user->tasks()->where('status', 'in-progress')->count();
    $pendingTasks = $user->tasks()->where('status', 'pending')->count();
    $upcomingTasks = $user->tasks()->where('due_date', '>=', now())
                                ->where('status', '!=', 'completed')
                                ->orderBy('due_date', 'asc')
                                ->take(5)
                                ->get();
    
    return view('dashboard', compact('totalTasks', 'completedTasks', 'inProgressTasks', 'pendingTasks', 'upcomingTasks'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Task routes
    Route::get('/tasks/{task}/delete', [TaskController::class, 'delete'])->name('tasks.delete');
    Route::resource('tasks', TaskController::class);
});

require __DIR__.'/auth.php';
