<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\TopicsController;
use App\Http\Controllers\CoursesController;
use App\Http\Controllers\UsersCoursesController;
use App\Http\Controllers\ContentsController; 
use App\Http\Controllers\UsersTopicsController;
use App\Http\Controllers\UsersContentsController; 
use App\Http\Controllers\UsersQuizController; 
use App\Http\Controllers\{
    QuizController,
    QuizQuestionController,
};
use App\Http\Controllers\UtilityController; 
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\ContactController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Public Routes
Route::get('/', function () {
    return view('welcome');
});

// Contact Routes
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

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
    // Admin Dashboard - Removed duplicates, keeping just one
    Route::get('/dashboard', [AdminController::class, 'index'])
        ->name('dashboard');

    // Certificate routes
    Route::get('/users/{encryptedUser}/certificate/print/{encryptedCourse}', 
        [CertificateController::class, 'print'])
        ->name('users.certificate.print');

    // Utilities - Fixed naming to match what's used in views
    Route::get('/utilities', [AdminController::class, 'utilitiesIndex'])
        ->name('utilities.index');
    Route::get('/utilities/create', [AdminController::class, 'createUtility'])
        ->name('utilities.create');
    Route::post('/utilities', [AdminController::class, 'storeUtility'])
        ->name('utilities.store');
    Route::get('/utilities/{utility}/edit', [AdminController::class, 'editUtility'])
        ->name('utilities.edit');
    Route::put('/utilities/{utility}', [AdminController::class, 'updateUtility'])
        ->name('utilities.update');
    Route::patch('/utilities/{utility}/toggle-publish', [AdminController::class, 'togglePublish'])
        ->name('utilities.toggle-publish');
    Route::delete('/utilities/{utility}', [AdminController::class, 'deleteUtility'])
        ->name('utilities.destroy');

    // Utility pages - Renamed to avoid conflicts
    Route::get('/terms-page', [UtilityController::class, 'show'])
        ->name('terms.page')
        ->defaults('type', 'terms');
    Route::get('/privacy-policy', [UtilityController::class, 'show'])
        ->name('privacy.policy')
        ->defaults('type', 'privacy');
    Route::get('/cookies-policy', [UtilityController::class, 'show'])
        ->name('cookies.policy')
        ->defaults('type', 'cookies');

    // Terms and Conditions Management - Renamed to avoid conflicts
    Route::get('/terms-management', [AdminController::class, 'indexTerms'])
        ->name('terms.index');
    Route::get('/terms-management/create', [AdminController::class, 'createTerms'])
        ->name('terms.create');
    Route::post('/terms-management', [AdminController::class, 'storeTerms'])
        ->name('terms.store');
    Route::get('/terms-management/{id}/edit', [AdminController::class, 'editTerms'])
        ->name('terms.edit');
    Route::put('/terms-management/{id}', [AdminController::class, 'updateTerms'])
        ->name('terms.update');
    Route::post('/terms-management/{id}/publish', [AdminController::class, 'publishTerms'])
        ->name('terms.publish');
    Route::delete('/terms-management/{id}', [AdminController::class, 'destroyTerms'])
        ->name('terms.destroy');

    // Reset Password - Removed duplicate
    Route::post('users/{encryptedUser}/reset-password', [UsersController::class, 'resetPassword'])
        ->name('users.reset-password');

    // User Management
    Route::get('/users', [UsersController::class, 'index'])
        ->name('users.index');
    Route::get('/users/create', [UsersController::class, 'create'])
        ->name('users.create');
    Route::post('/users', [UsersController::class, 'store'])
        ->name('users.store');
    Route::get('/users/{encryptedUser}/edit', [UsersController::class, 'edit'])
        ->name('users.edit');
    Route::put('/users/{encryptedUser}', [UsersController::class, 'update'])
        ->name('users.update');
    Route::delete('/users/{encryptedUser}', [UsersController::class, 'destroy'])
        ->name('users.destroy');
    Route::get('/users/{encryptedUser}', [UsersController::class, 'show'])
        ->name('users.show');
    
    // Courses Management (CRUD)
    Route::resource('courses', CoursesController::class)->parameters([
        'courses' => 'encryptedCourse'
    ]);
    Route::post('/courses/{encryptedCourse}/add-topic', [CoursesController::class, 'addTopic'])
        ->name('courses.addTopic');
    Route::post('courses/{encryptedCourse}/assign-roles', [CoursesController::class, 'assignRoles'])
        ->name('courses.assign-roles'); // Fixed naming inconsistency
    Route::put('/courses/{encryptedCourse}/assign-roles', [CoursesController::class, 'assignRoles'])
        ->name('courses.update-roles'); // Fixed naming inconsistency
    Route::delete('/courses/{encryptedCourse}/topics/{encryptedTopic}/remove', [CoursesController::class, 'removeTopic'])
        ->name('courses.removeTopic');

    // Enrolled Users Management
    Route::get('/courses/{encryptedCourse}/users', [CoursesController::class, 'showUsers'])
        ->name('courses.show-users');

    // Contents Management 
    Route::get('/contents', [ContentsController::class, 'index'])
        ->name('contents.index');
    Route::get('/topics/contents/{encryptedContent}', [ContentsController::class, 'show'])
        ->name('contents.show');

    // Topics Management (CRUD)
    Route::resource('topics', TopicsController::class)->parameters([
        'topics' => 'encryptedTopic'
    ]);
    // Route::put('/topics', [TopicsController::class, 'update'])
    //     ->name('topics.update'); // Fixed prefix inconsistency
    
    // Quiz Management (Nested under Topics)
    Route::prefix('topics/{encryptedTopic}/quiz')->name('topics.quiz.')->group(function () {
        // Quiz routes
        Route::get('/', [QuizController::class, 'index'])->name('index');
        Route::get('/create', [QuizController::class, 'create'])->name('create');
        Route::post('/', [QuizController::class, 'store'])->name('store');
        Route::get('/{encryptedQuiz}', [QuizController::class, 'show'])->name('show');
        Route::get('/{encryptedQuiz}/edit', [QuizController::class, 'edit'])->name('edit');
        Route::put('/{encryptedQuiz}', [QuizController::class, 'update'])->name('update');
        Route::delete('/{encryptedQuiz}', [QuizController::class, 'destroy'])->name('destroy');
        
        // Quiz questions routes (nested under specific quiz)
        Route::prefix('{encryptedQuiz}/questions')->name('questions.')->group(function () {
            Route::get('/create', [QuizQuestionController::class, 'create'])->name('create');
            Route::post('/', [QuizQuestionController::class, 'store'])->name('store');
            Route::put('/{encryptedQuestion}', [QuizQuestionController::class, 'update'])->name('update');
            Route::delete('/{encryptedQuestion}', [QuizQuestionController::class, 'destroy'])->name('destroy');
        });
        
        // User quiz routes
        Route::get('/{encryptedQuiz}/user', [QuizController::class, 'viewAsUser'])
            ->name('user_quiz');
        Route::post('/{encryptedQuiz}/user', [QuizController::class, 'submitQuiz'])
            ->name('submit');
    });
});

// For regular users
Route::middleware('auth')->group(function () {
    Route::get('/users/dashboard', [UsersController::class, 'dashboard'])->name('users.dashboard');

    // Certificate routes
    Route::middleware('auth')->group(function () {
        Route::get('/users/{encryptedUser}/courses/{encryptedCourse}/certificate', 
            [CertificateController::class, 'print'])
            ->name('users.certificate.print');
    });

    // Courses Management
    Route::get('/users/courses', [UsersCoursesController::class, 'index'])
        ->name('users.courses.index');
    Route::get('/users/courses/{encryptedCourse}', [UsersCoursesController::class, 'show'])
        ->name('users.courses.show');
    Route::get('/users/contents/{encryptedTopic}', [UsersContentsController::class, 'show'])
        ->name('users.contents.show');
    Route::get('/courses/{encryptedCourse}/certificate', [UsersCoursesController::class, 'certificate'])
        ->name('users.courses.certificate');

    Route::post('/users/courses/{encryptedCourse}/enroll', [UsersCoursesController::class, 'enroll'])
        ->name('users.courses.enroll');
    
    Route::delete('/users/courses/{encryptedCourse}/unenroll', [UsersCoursesController::class, 'unenroll'])
        ->name('users.courses.unenroll');

    // Quiz Management
    Route::get('users/topics/{encryptedTopic}/quizzes/{encryptedQuiz}', 
        [UsersQuizController::class, 'show'])
        ->name('users.quiz.show');

    Route::post('/users/topics/{encryptedTopic}/quizzes/{encryptedQuiz}/submit', [UsersQuizController::class, 'submit'])
        ->name('users.quiz.submit');
});

require __DIR__.'/auth.php';