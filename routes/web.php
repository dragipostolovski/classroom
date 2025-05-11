<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\WorkspaceController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    // Route::resource('workspaces', WorkspaceController::class);
    Route::resource('projects', ProjectController::class);
    Route::resource('tickets', TicketController::class);
    Route::post('workspaces/{workspace}/assign-user', [WorkspaceController::class, 'assignUser'])->name('workspaces.assignUser');
    Route::post('projects/{project}/assign-user', [ProjectController::class, 'assignUser'])->name('projects.assignUser');
    Route::resource('projects', ProjectController::class)->only(['store']);
    Route::post('tickets/{ticket}/update-status', [TicketController::class, 'updateStatus']);
    Route::resource('tickets', TicketController::class);
    Route::get('profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    
    Route::resource('classes', ClassController::class);
    Route::resource('classes.lessons', LessonController::class);
    Route::resource('classes.assignments', AssignmentController::class);
    Route::resource('classes.quizzes', QuizController::class);
    Route::resource('quizzes.questions', QuestionController::class);
    Route::post('/classes/{class}/assignments', [AssignmentController::class, 'store'])->name('classes.assignments.store');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::middleware(['auth'])->group(function () {
    Route::resource('workspaces', WorkspaceController::class);
});

Route::get('register', [RegisteredUserController::class, 'create'])
    ->middleware('guest')
    ->name('register');
Route::post('register', [RegisteredUserController::class, 'store'])
    ->middleware('guest');
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');
require __DIR__.'/auth.php';

// Profile routes
Route::middleware(['auth'])->group(function () {
    Route::get('/profile/edit', function () {
        $user = auth()->user();
        return view('auth.profile', compact('user'));
    })->name('profile.edit');

    Route::put('/profile/update', function (\Illuminate\Http\Request $request) {
        $user = auth()->user();
        $validated = $request->validate([
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'linked_url' => 'nullable|url',
        ]);
        if (!empty($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }
        $user->update($validated);
        return redirect()->route('profile.edit')->with('success', 'Profile updated!');
    })->name('profile.update');
});

require __DIR__.'/auth.php';