<?php

use App\Http\Controllers\Admin\ProjectController as AdminProjectController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\InvitationGuestController;
use App\Http\Controllers\InvitationWishController;
use App\Http\Controllers\PublicInvitationController;
use App\Http\Controllers\StudioController;
use App\Http\Controllers\WritingAuthorController;
use App\Http\Controllers\WritingController;
use Illuminate\Support\Facades\Route;

Route::get('/', [StudioController::class, 'index'])->name('home');
Route::get('/undangan-digital', [StudioController::class, 'invitations'])->name('studio.invitations');
Route::get('/karya/{project:slug}', [StudioController::class, 'project'])->name('projects.show');
Route::get('/ruang-baca', [WritingController::class, 'index'])->name('readings.index');
Route::get('/ruang-baca/daftar-penulis', [WritingAuthorController::class, 'create'])->name('writers.register');
Route::post('/ruang-baca/daftar-penulis', [WritingAuthorController::class, 'store'])->middleware('throttle:3,1')->name('writers.register.store');
Route::get('/ruang-baca/masuk', [AuthController::class, 'writerLogin'])->middleware('guest')->name('writers.login');
Route::get('/ruang-baca/{writing:slug}', [WritingController::class, 'show'])->name('readings.show');

Route::middleware('guest')->group(function (): void {
    Route::get('/masuk', [AuthController::class, 'login'])->name('login');
    Route::post('/masuk', [AuthController::class, 'storeLogin'])->middleware('throttle:login')->name('login.store');
    Route::get('/daftar', [AuthController::class, 'register'])->name('register');
    Route::post('/daftar', [AuthController::class, 'storeRegistration'])->middleware('throttle:3,1')->name('register.store');
});

Route::get('/i/{invitation:slug}/{token}', [PublicInvitationController::class, 'show'])->name('invitations.public.show');
Route::post('/i/{invitation:slug}/{token}/rsvp', [PublicInvitationController::class, 'rsvp'])->middleware('throttle:20,1')->name('invitations.public.rsvp');
Route::post('/i/{invitation:slug}/{token}/ucapan', [InvitationWishController::class, 'store'])->middleware('throttle:10,1')->name('invitations.public.wishes.store');

Route::middleware('auth')->prefix('dashboard')->name('dashboard.')->group(function (): void {
    Route::get('/', [DashboardController::class, 'index'])->name('index');
    Route::post('/keluar', [AuthController::class, 'logout'])->name('logout');
    Route::get('/ruang-tulis', [WritingController::class, 'dashboardIndex'])->name('writings.index');
    Route::get('/ruang-tulis/buat', [WritingController::class, 'create'])->name('writings.create');
    Route::post('/ruang-tulis', [WritingController::class, 'store'])->name('writings.store');
    Route::get('/ruang-tulis/{writing}/edit', [WritingController::class, 'edit'])->name('writings.edit');
    Route::put('/ruang-tulis/{writing}', [WritingController::class, 'update'])->name('writings.update');
    Route::delete('/ruang-tulis/{writing}', [WritingController::class, 'destroy'])->name('writings.destroy');
    Route::resource('invitations', InvitationController::class)->except(['index']);
    Route::post('/invitations/{invitation}/guests', [InvitationGuestController::class, 'store'])->name('guests.store');
    Route::put('/invitations/{invitation}/guests/{guest}', [InvitationGuestController::class, 'update'])->name('guests.update');
    Route::delete('/invitations/{invitation}/guests/{guest}', [InvitationGuestController::class, 'destroy'])->name('guests.destroy');
    Route::post('/invitations/{invitation}/guests/{guest}/tandai-terkirim', [InvitationGuestController::class, 'markSent'])->name('guests.mark-sent');
    Route::post('/invitations/{invitation}/wishes/{wish}/approve', [InvitationWishController::class, 'approve'])->name('wishes.approve');

    Route::middleware('admin')->prefix('studio')->name('admin.')->group(function (): void {
        Route::resource('projects', AdminProjectController::class);
        Route::resource('services', AdminServiceController::class);
    });
});
