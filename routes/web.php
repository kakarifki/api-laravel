<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $tasks = [];
    if (auth()->check()) {
        $tasks = auth()->user()->tasks()
            ->whereIn('status', ['pending', 'in-progress'])
            ->orderBy('due_date')
            ->limit(3)
            ->get();
    }
    return view('dashboard', [
        'totalTasks' => auth()->check() ? auth()->user()->tasks()->count() : 0,
        'completedTasks' => auth()->check() ? auth()->user()->tasks()->where('status', 'completed')->count() : 0,
        'inProgressTasks' => auth()->check() ? auth()->user()->tasks()->where('status', 'in-progress')->count() : 0,
        'pendingTasks' => auth()->check() ? auth()->user()->tasks()->where('status', 'pending')->count() : 0,
        'upcomingTasks' => $tasks
    ]);
});

use App\Models\Task;
use Illuminate\Support\Facades\Auth;

Route::get('/dashboard', function () {
    $user = Auth::user();
    $upcomingTasks = collect();

    if ($user) {
        $upcomingTasks = $user->tasks()
            ->whereIn('status', ['pending', 'in-progress'])
            ->orderBy('due_date', 'asc')
            ->take(3)
            ->get();
    }

    $totalTasks = $user ? $user->tasks()->count() : 0;
    $pendingTasks = $user ? $user->tasks()->where('status', 'pending')->count() : 0;
    $inProgressTasks = $user ? $user->tasks()->where('status', 'in-progress')->count() : 0;
    $completedTasks = $user ? $user->tasks()->where('status', 'completed')->count() : 0;

    return view('dashboard', compact('totalTasks', 'completedTasks', 'inProgressTasks', 'pendingTasks', 'upcomingTasks'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/tasks/create', [App\Http\Controllers\TaskController::class, 'create'])->name('tasks.create');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Task routes
    Route::get('/tasks/{task}/delete', [TaskController::class, 'delete'])->name('tasks.delete');
    Route::resource('tasks', TaskController::class);
});

require __DIR__.'/auth.php';
