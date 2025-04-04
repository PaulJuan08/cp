<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\TopicsController;
use App\Http\Controllers\CoursesController;
use App\Http\Controllers\UsersCoursesController;
use App\Http\Controllers\ContentsController; 
use App\Http\Controllers\UsersContentsController; 
use App\Http\Controllers\UsersQuizController; 
use App\Http\Controllers\{
    QuizController,
    QuizQuestionController,
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
    Route::post('courses/{course}/assign-roles', [CoursesController::class, 'assignRoles'])
        ->name('admin.courses.assign-roles');
    Route::put('/courses/{course}/assign-roles', [CoursesController::class, 'assignRoles'])
    ->name('admin.courses.assign-roles');


    // Contents Management 
    Route::get('/contents', [ContentsController::class, 'index'])
    ->name('contents.index'); // Show all topics
    Route::get('/topics/contents/{id}', [ContentsController::class, 'show'])
    ->name('contents.show'); // Show a single topic

    // Topics Management (CRUD)
    Route::resource('topics', TopicsController::class);
    Route::put('/admin/topics', [TopicsController::class, 'update'])->name('admin.topics.update');

    

 
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
        Route::delete('/{quiz}/questions/{question}', 
        [QuizQuestionController::class, 'destroy'])->name('questions.destroy');



        // View as User Route (Corrected)
        Route::get('/{quiz}/user', [QuizController::class, 'viewAsUser'])
        ->name('user_quiz');

        Route::post('/{quiz}/user', [QuizController::class, 'submitQuiz'])
        ->name('submit');



    });
});

// For regular users
Route::middleware('auth')->group(function () {
    Route::get('/users/dashboard', [UsersController::class, 'dashboard'])->name('users.dashboard');
    Route::get('/users/dashboard', [UsersController::class, 'userindex'])->name('users.dashboard');

    // Courses Management
    Route::get('/users/courses', [UsersCoursesController::class, 'index'])->name('users.courses.index');
    Route::get('/users/courses/{id}', [UsersCoursesController::class, 'show'])->name('users.courses.show');
    Route::get('/users/contents/{id}', [UsersContentsController::class, 'show'])->name('users.contents.show');

    // Quiz Management
    Route::get('/users/topics/{topic}/quizzes/{quiz}', [UsersQuizController::class, 'show'])
        ->name('users.quiz.show');

    Route::post('/users/topics/{topic}/quizzes/{quiz}/submit', [UsersQuizController::class, 'submit'])
        ->name('users.quiz.submit');
});


// Authentication Routes
require __DIR__.'/auth.php';
