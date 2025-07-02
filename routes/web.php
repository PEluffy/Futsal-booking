<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CourtsController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\PageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;


Route::middleware('guest')->controller(ForgotPasswordController::class)->group(function () {
    Route::get('/forgot-password', 'showForgotPasswordPage')->name('password.request');
    Route::post('/forgot-password', 'emailLink')->name('password.email');
    Route::get('/reset-password/{token}', 'showResetPasswordForm')->name('password.reset');
    Route::post('/reset-password', 'resetYourPassword')->name('password.update');
});


Route::controller(PageController::class)->group(function () {

    Route::middleware(['authmiddleware'])->group(function () {
        Route::get('/login', 'showLogin')->name('show.login');
        Route::get('/register', 'showRegister')->name('show.register');
    });

    Route::get('/', 'showIndex')->name('show.index');
    Route::get('/about', 'showAbout')->name('show.about');
    Route::get('/facilities', 'showFacilities')->name('show.facilities');
    Route::get('/courts', 'showCourts')->name('show.courts');
    Route::get('/booking', 'showBooking')->name('show.booking')->middleware('userguestmiddleware');
});

Route::controller(AuthController::class)->group(function () {
    Route::post('/register', 'register')->name('register');
    Route::post('/logout', 'logout')->name('logout');
    Route::post('/login', 'login')->name('login');
});

Route::prefix('admin')->group(function () {

    Route::middleware(['adminguestmiddleware'])->group(function () {
        Route::get('/', fn() => view('admin.pages.dashboard'))->name('admin.index');
        Route::get('/dashboard', fn() => view('admin.pages.dashboard'))->name('admin.dashboard');
        // Route::get('/courts', fn() => view('admin.pages.courts'))->name('admin.courts');
        Route::get('/courts', [CourtsController::class, 'showCourts'])->name('admin.courts');
        Route::get('/contact', [ContactController::class, 'showContact'])->name('admin.show.contact');
        Route::get('/facility', [FacilityController::class, 'showFacility'])->name('admin.show.facility');
    });

    Route::get('/login', fn() => view('admin.pages.login'))->name('admin.show.login')->middleware('adminauthmiddleware');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
    Route::post('/contact', [ContactController::class, 'updateContact'])->name('admin.update.contact');
    Route::post('/court', [CourtsController::class, 'createCourt'])->name('admin.create.court');
});


Route::prefix('email')->group(function () {

    Route::get('/verify', function () {
        return view('pages.verify-email');
    })->middleware('auth')->name('verification.notice');

    Route::post('/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('message', 'Verification link sent!');
    })->middleware(['auth', 'throttle:6,1'])->name('verification.send');

    //why emailverificationrequest instead of normal http request  beacuse this will handle the request id and hash parameter comming from the request automaticcalyy
    Route::get('/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill(); //this will make Email as verified 

        return redirect('/');
    })->middleware(['auth', 'signed'])->name('verification.verify');
});

Route::post('/booking', [BookingController::class, 'bookCourt'])->name('book.court')->middleware('userverifiedmiddleware');

Route::post('/reserve-time', [BookingController::class, 'reserveCourt'])->name('reserve.court')->middleware('userverifiedmiddleware');
Route::post('/admin/facility', [FacilityController::class, 'createFacility'])->name('admin.create.facility');
