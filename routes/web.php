<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\TopicsController;
use App\Http\Controllers\CoursesController;
use App\Http\Controllers\ContentsController; 
use App\Http\Controllers\{
    QuizController,
    QuizQuestionController,
    QuizAnswerController
};

// Public Routes
Route::get('/', function () {
    return view('welcome');
});

// Authenticated Routes
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])
    ->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])
    ->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])
    ->name('profile.destroy');
});

// Admin Routes
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Admin Dashboard
    Route::get('/dashboard', [AdminController::class, 'index'])
    ->name('dashboard');

    // User Management
    Route::get('/users', [UsersController::class, 'index'])
    ->name('users.index');

    // Courses Management (CRUD)
    Route::resource('courses', CoursesController::class);
    Route::post('/courses/{course}/add-topic', [CoursesController::class, 'addTopic'])
    ->name('courses.addTopic');

    // Contents Management 
    Route::get('/contents', [ContentsController::class, 'index'])
    ->name('contents.index'); // Show all topics
    Route::get('/topics/contents/{id}', [ContentsController::class, 'show'])
    ->name('contents.show'); // Show a single topic

    // Topics Management (CRUD)
    Route::resource('topics', TopicsController::class);

 
    // Quiz Management (Nested under Topics)
    Route::prefix('topics/{topic}/quiz')->name('topics.quiz.')->group(function () {
        Route::get('/', [QuizController::class, 'index'])->name('index'); // Matches topics.quiz.index
        Route::get('/create', [QuizController::class, 'create'])->name('create');
        Route::post('/', [QuizController::class, 'store'])->name('store');
        Route::get('/{quiz}', [QuizController::class, 'show'])->name('show');
        Route::get('/{quiz}/edit', [QuizController::class, 'edit'])->name('edit');
        Route::put('/{quiz}', [QuizController::class, 'update'])->name('update');
        Route::delete('/{quiz}', [QuizController::class, 'destroy'])->name('destroy');
        Route::post('/{quiz}/questions', [QuizQuestionController::class, 'store'])->name('questions.store');

    });
});


// Authentication Routes
require __DIR__.'/auth.php';
