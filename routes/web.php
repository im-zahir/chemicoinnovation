<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ContactSettingController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\AboutSettingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\SolutionController;
use App\Http\Controllers\CategoryController as PublicCategoryController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Routes
Route::middleware(['web'])->group(function () {
    // Frontend Routes
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('about', [AboutController::class, 'index'])->name('about');
    Route::get('contact', [ContactController::class, 'index'])->name('contact');
    Route::get('products', [ProductController::class, 'index'])->name('products.index');
    Route::get('products/{product}', [ProductController::class, 'show'])->name('products.show');
    Route::get('/solution', [SolutionController::class, 'index'])->name('solution');

    // Categories
    Route::get('categories/{category}', [PublicCategoryController::class, 'show'])->name('categories.show');

    // Solutions
    Route::prefix('solutions')->name('solutions.')->group(function () {
        Route::get('/industrial-chemicals', [SolutionController::class, 'industrialChemicals'])->name('industrial-chemicals');
        Route::get('/laboratory-solutions', [SolutionController::class, 'laboratorySolutions'])->name('laboratory-solutions');
        Route::get('/custom-formulations', [SolutionController::class, 'customFormulations'])->name('custom-formulations');
        Route::get('/safety-equipment', [SolutionController::class, 'safetyEquipment'])->name('safety-equipment');
        Route::get('/quality-control', [SolutionController::class, 'qualityControl'])->name('quality-control');
        Route::get('/rd-services', [SolutionController::class, 'rdServices'])->name('rd-services');
    });
});

// Non-cached routes
Route::middleware('web')->group(function () {
    Route::post('contact', [ContactController::class, 'store'])->name('contact.store');
    Route::get('login', function() {
        return redirect()->route('admin.auth.login');
    })->name('login');
});

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['web'])->group(function () {
    // Guest routes (login)
    Route::middleware('guest')->group(function () {
        Route::get('login', [LoginController::class, 'showLoginForm'])->name('auth.login');
        Route::post('login', [LoginController::class, 'login'])->name('auth.login.post');
    });

    // Protected admin routes
    Route::middleware('auth')->group(function () {
        // Dashboard
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::post('logout', [LoginController::class, 'logout'])->name('auth.logout');
        
        // Settings Management
        Route::prefix('settings')->name('settings.')->group(function () {
            Route::get('/', [SettingController::class, 'index'])->name('index');
            Route::post('/', [SettingController::class, 'update'])->name('update');
        });

        // Product Management
        Route::resource('products', AdminProductController::class);
        
        // Category Management
        Route::resource('categories', CategoryController::class);
        
        // Contact Settings
        Route::prefix('contact')->name('contact.')->group(function () {
            Route::get('/', [ContactSettingController::class, 'edit'])->name('edit');
            Route::put('/', [ContactSettingController::class, 'update'])->name('update');
        });
        
        // About Settings
        Route::prefix('about')->name('about.')->group(function () {
            Route::get('settings', [AboutSettingController::class, 'edit'])->name('edit');
            Route::put('settings', [AboutSettingController::class, 'update'])->name('update');
        });
        
        // Team Management
        Route::resource('teams', TeamController::class);

        // Testimonial Management
        Route::resource('testimonials', TestimonialController::class);
        
        // User Management
        Route::resource('users', UserController::class);
    });
});
