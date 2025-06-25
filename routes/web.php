<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CourtsController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\PageController;
use App\Http\Middleware\AdminAuthMiddleware;
use App\Http\Middleware\AuthMiddleware;
use App\Http\Middleware\IfAdminIsLoginMiddleware;
use App\Http\Middleware\IsUserLoggedInMiddleware;
use Illuminate\Support\Facades\Route;


Route::controller(ForgotPasswordController::class)->group(function () {

    Route::get('/forgot-password',  'showForgotPasswordPage')->middleware('guest')->name('password.request');

    Route::post('/forgot-password',  'emailLink')->middleware('guest')->name('password.email');

    Route::get('/reset-password/{token}',  'showResetPasswordForm')->middleware('guest')->name('password.reset');

    Route::post('/reset-password',  'resetYourPassword')->middleware('guest')->name('password.update');
});

Route::controller(PageController::class)->group(function () {
    Route::get('/login', 'showLogin')->name('show.login')->middleware(AuthMiddleware::class);
    Route::get('/register', 'showRegister')->name('show.register')->middleware(AuthMiddleware::class);
    Route::get('/', 'showIndex')->name('show.index');
    Route::get('/about', 'showAbout')->name('show.about');
    Route::get('/facilities', 'showFacilities')->name('show.facilities');
    Route::get('/courts', 'showCourts')->name('show.courts');
    Route::get('/booking', 'showBooking')->name('show.booking')->middleware(IsUserLoggedInMiddleware::class);
});

Route::controller(AuthController::class)->group(function () {
    Route::post('/register', 'register')->name('register');
    Route::post('/logout', 'logout')->name('logout');
    Route::post('/login', 'login')->name('login');
});

Route::prefix('admin')->group(function () {
    Route::get('/', fn() => view('admin.pages.dashboard'))->name('admin.index')->middleware(AdminAuthMiddleware::class);
    Route::get('/login', fn() => view('admin.pages.login'))->name('admin.show.login')->middleware(IfAdminIsLoginMiddleware::class);;
    Route::get('/dashboard', fn() => view('admin.pages.dashboard'))->name('admin.dashboard')->middleware(AdminAuthMiddleware::class);
    Route::get('/courts', fn() => view('admin.pages.courts'))->name('admin.courts')->middleware(AdminAuthMiddleware::class);
    Route::get('/contact', [ContactController::class, 'showContact'])->name('admin.show.contact');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
    Route::get('/courts', [CourtsController::class, 'showCourts'])->name('admin.courts');
    Route::post('/contact', [ContactController::class, 'updateContact'])->name('admin.update.contact');
    Route::post('/court', [CourtsController::class, 'createCourt'])->name('admin.create.court');
});
