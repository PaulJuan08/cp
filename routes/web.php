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
    QuizItemController,
    QuizOptionController
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

 
    // Quiz Routes
    Route::prefix('topics/{topic}')->group(function () {

        // Quiz Creation
        Route::get('/quiz/create', [QuizController::class, 'create'])
        ->name('topics.quiz.create');
        Route::post('/quiz/store', [QuizController::class, 'store'])
        ->name('topics.quiz.store');

        // Quiz Management
        Route::get('/quiz/{quiz}', [QuizController::class, 'show'])
        ->name('topics.quiz.show');
        Route::get('/quiz/{quiz}/edit', [QuizController::class, 'edit'])
        ->name('topics.quiz.edit');
        Route::put('/quiz/{quiz}', [QuizController::class, 'update'])
        ->name('topics.quiz.update');

        // Quiz Items Management
        Route::prefix('/quiz/{quiz}/items')->group(function () {
            Route::get('/create', [QuizItemController::class, 'create'])
            ->name('topics.quiz.items.create');
            Route::post('/', [QuizItemController::class, 'store'])
            ->name('topics.quiz.items.store');
            Route::get('/{item}/edit', [QuizItemController::class, 'edit'])
            ->name('topics.quiz.items.edit');
            Route::put('/{item}', [QuizItemController::class, 'update'])
            ->name('topics.quiz.items.update');
            Route::delete('/{item}', [QuizItemController::class, 'destroy'])
            ->name('topics.quiz.items.destroy');

            // Quiz Options Management
            Route::prefix('/{item}/options')->group(function () {
                Route::post('/', [QuizOptionController::class, 'store'])
                ->name('topics.quiz.items.options.store');
                Route::put('/{option}', [QuizOptionController::class, 'update'])
                ->name('topics.quiz.items.options.update');
                Route::delete('/{option}', [QuizOptionController::class, 'destroy'])
                ->name('topics.quiz.items.options.destroy');
            });
        });
    });

});



// Authentication Routes
require __DIR__.'/auth.php';
