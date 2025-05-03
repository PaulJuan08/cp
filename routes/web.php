<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\TopicsController;
use App\Http\Controllers\CoursesController;
use App\Http\Controllers\ContentsController; 
<<<<<<< Updated upstream
=======
use App\Http\Controllers\UsersContentsController; 
use App\Http\Controllers\UsersQuizController; 
use App\Http\Controllers\{
    QuizController,
    QuizQuestionController,
};
use App\Http\Controllers\UtilityController; 
use App\Http\Controllers\CertificateController;

>>>>>>> Stashed changes

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
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Admin Dashboard
<<<<<<< Updated upstream
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
=======
    Route::get('/dashboard', [AdminController::class, 'index'])
    ->name('dashboard');

    // Certificate routes
    Route::get('/users/{encryptedUser}/courses/{encryptedCourse}/certificate', 
    [CertificateController::class, 'print'])
    ->name('users.certificate.print');

    // Utilities - Resourceful routes with additional custom actions
    Route::prefix('utilities')->name('utilities.')->group(function () {
        Route::get('/', [AdminController::class, 'utilitiesIndex'])
            ->name('index');
        Route::get('/create', [AdminController::class, 'createUtility'])
            ->name('create');
        Route::post('/', [AdminController::class, 'storeUtility'])
            ->name('store');
        Route::get('/{utility}/edit', [AdminController::class, 'editUtility'])
            ->name('edit');
        Route::put('/{utility}', [AdminController::class, 'updateUtility'])
            ->name('update');
        Route::patch('/{utility}/toggle-publish', [AdminController::class, 'togglePublish'])
            ->name('toggle-publish');
        Route::delete('/{utility}', [AdminController::class, 'deleteUtility'])
            ->name('destroy');
    });

    // Utility pages
    Route::get('/terms', [UtilityController::class, 'show'])->name('terms')->defaults('type', 'terms');
    Route::get('/privacy', [UtilityController::class, 'show'])->name('privacy')->defaults('type', 'privacy');
    Route::get('/cookies', [UtilityController::class, 'show'])->name('cookies')->defaults('type', 'cookies');

    // Reset Password
    Route::post('users/{encryptedUser}/reset-password', [UsersController::class, 'resetPassword'])
        ->name('users.reset-password');
>>>>>>> Stashed changes

    // User Management
    Route::get('/users', [UsersController::class, 'index'])->name('users.index');

    // Courses Management (CRUD)
    Route::resource('courses', CoursesController::class);
    Route::post('/courses/{course}/add-topic', [CoursesController::class, 'addTopic'])->name('courses.addTopic');

    // Contents Management 
    Route::get('/contents', [ContentsController::class, 'index'])->name('contents.index'); // Show all topics
    Route::get('topics/contents/{id}', [ContentsController::class, 'show'])->name('contents.show'); // Show a single topic

    // Topics Management (CRUD)
    Route::resource('topics', TopicsController::class);
});

// Authentication Routes
require __DIR__.'/auth.php';
