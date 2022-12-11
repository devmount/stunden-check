<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
// use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
	// Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
	// Route::post('/register', [RegisteredUserController::class, 'store']);
	Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
	Route::post('/login', [AuthenticatedSessionController::class, 'store']);
	Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
	Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
	Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
	Route::post('/reset-password', [NewPasswordController::class, 'store'])->name('password.update');
});

Route::middleware('auth')->group(function () {
	Route::get('/', [PositionController::class, 'index'])->name('dashboard');
	Route::get('/positions/add', [PositionController::class, 'create'])->name('positions-add');
	Route::post('/positions/add', [PositionController::class, 'store']);
	Route::get('/positions/edit/{id}', [PositionController::class, 'edit'])->name('positions-edit');
	Route::post('/positions/edit/{id}', [PositionController::class, 'update']);
	Route::post('/positions/delete/{id}', [PositionController::class, 'delete'])->name('positions-delete');
	Route::get('/verify-email', [EmailVerificationPromptController::class, '__invoke'])->name('verification.notice');
	Route::get('/verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
		->middleware(['signed', 'throttle:6,1'])->name('verification.verify');
	Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
		->middleware('throttle:6,1')->name('verification.send');
	Route::get('/confirm-password', [ConfirmablePasswordController::class, 'show'])->name('password.confirm');
	Route::post('/confirm-password', [ConfirmablePasswordController::class, 'store']);
	Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
	Route::get('/profile/password', [ProfileController::class, 'password'])->name('password.change');
	Route::post('/profile/password', [ProfileController::class, 'update']);
	Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

Route::middleware('admin')->group(function () {
	Route::get('/accounts', [AccountController::class, 'index'])->name('accounts');
	Route::get('/accounts/add', [AccountController::class, 'create'])->name('accounts-add');
	Route::post('/accounts/add', [AccountController::class, 'store']);
	Route::get('/accounts/positions/{id}', [AccountController::class, 'positions'])->name('accounts-positions');
	Route::get('/accounts/edit/{id}', [AccountController::class, 'edit'])->name('accounts-edit');
	Route::post('/accounts/edit/{id}', [AccountController::class, 'update']);
	Route::post('/accounts/archive/{id}', [AccountController::class, 'archive'])->name('accounts-archive');
	Route::post('/accounts/recycle/{id}', [AccountController::class, 'recycle'])->name('accounts-recycle');
	Route::post('/accounts/delete/{id}', [AccountController::class, 'delete'])->name('accounts-delete');
	Route::get('/accounts/reminder', [AccountController::class, 'reminder'])->name('accounts-reminder');
	Route::post('/accounts/reminder', [AccountController::class, 'remind']);
	Route::get('/accounts/export/{ext}', [AccountController::class, 'export'])->name('accounts-export');
	Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
	Route::post('/settings', [SettingsController::class, 'update']);
	Route::post('/test/mail', [SettingsController::class, 'send'])->name('testmail');
	Route::get('/settings/cat/add', [CategoryController::class, 'create'])->name('categories-add');
	Route::post('/settings/cat/add', [CategoryController::class, 'store']);
	Route::get('/settings/cat/edit/{id}', [CategoryController::class, 'edit'])->name('categories-edit');
	Route::post('/settings/cat/edit/{id}', [CategoryController::class, 'update']);
	Route::post('/settings/cat/delete/{id}', [CategoryController::class, 'delete'])->name('categories-delete');
});
