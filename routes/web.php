<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SuperadminController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

Route::get('/', [HomeController::class, 'index']);
Route::get('/lupa_password', [LoginController::class, 'lupa_password']);
Route::post('/lupa_password', [LoginController::class, 'sendLink']);
Route::get('/reset-password/{token}', [LoginController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('/reset-password', [LoginController::class, 'resetPassword'])->name('password.update');

Route::get('/register', [RegisterController::class, 'index']);
Route::post('/register', [RegisterController::class, 'store']);

Route::get('/email/verify', function () {
    $data = Auth::user()->profile;
    return view('auth.verify-email', compact('data'));
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/user/home');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::get('/email/verification-notification', function () {
    Auth::user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::middleware(['auth', 'verified', 'user'])->group(function () {

    Route::get('/user/pengaduan/add', [UserController::class, 'tambahPengaduan']);
    Route::post('/user/pengaduan/add', [UserController::class, 'simpanPengaduan']);
    Route::get('/user/pengaduan/delete/{id}', [UserController::class, 'deletePengaduan']);
    Route::get('/downloadfotoigkandidat/{id}', [UserController::class, 'downloadFoto']);
    Route::get('/user/home/kirimlamaran', [UserController::class, 'kirim']);
    Route::get('/user/home', [UserController::class, 'home']);
    Route::post('/user/home/upload', [UserController::class, 'upload']);
    Route::get('/user/home/editprofile', [UserController::class, 'editProfile']);
    Route::post('/user/home/editprofile', [UserController::class, 'updateProfile']);
    Route::get('/user/home/essay', [UserController::class, 'essay']);
    Route::post('/user/home/essay', [UserController::class, 'updateEssay']);
    Route::get('/user/downloadfotoig/{id}', [SuperadminController::class, 'downloadFoto']);
});

Route::middleware(['auth', 'superadmin'])->group(function () {
    Route::get('/admin/pengaduan/add', [SuperadminController::class, 'tambahPengaduan']);
    Route::post('/admin/pengaduan/add', [SuperadminController::class, 'simpanPengaduan']);
    Route::get('/admin/pengaduan/delete/{id}', [SuperadminController::class, 'deletePengaduan']);
    Route::get('/admin/pengaduan/proses/{id}', [SuperadminController::class, 'prosesPengaduan']);
    Route::get('/admin/pengaduan/selesai/{id}', [SuperadminController::class, 'selesaiPengaduan']);
    Route::get('/admin/pengaduan/tolak/{id}', [SuperadminController::class, 'tolakPengaduan']);
    Route::get('/admin/detailpendaftar/{id}', [SuperadminController::class, 'detailPendaftar']);
    Route::post('/admin/detailpendaftar/{id}', [SuperadminController::class, 'uploadFoto']);
    Route::post('/admin/detailpendaftar/{id}/instagram', [SuperadminController::class, 'updateInstagram']);
    Route::get('/deletefotoig/{id}', [SuperadminController::class, 'deleteFoto']);
    Route::get('/downloadfotoig/{id}', [SuperadminController::class, 'downloadFoto']);
    Route::get('/admin/berkaspendaftar/{id}', [SuperadminController::class, 'berkasPendaftar']);
    Route::get('/admin/deletependaftar/{id}', [SuperadminController::class, 'deletePendaftar']);
    Route::post('/admin/validasi', [SuperadminController::class, 'validasi']);
    Route::get('/admin/streampdf/{id}', [SuperadminController::class, 'streamPDF']);
    Route::get('/admin/ktp/{id}', [SuperadminController::class, 'streamKTP']);
    Route::get('/admin/ijazah/{id}', [SuperadminController::class, 'streamIJAZAH']);
    Route::get('/admin/sertifikat/{id}', [SuperadminController::class, 'streamSERTIFIKAT']);

    Route::get('/admin/setting', [SuperadminController::class, 'setting']);
    Route::post('/admin/setting', [SuperadminController::class, 'updateSetting']);

    Route::get('/admin/bidang', [SuperadminController::class, 'bidang']);
    Route::get('/admin/bidang/add', [SuperadminController::class, 'add_bidang']);
    Route::post('/admin/bidang/add', [SuperadminController::class, 'store_bidang']);
    Route::get('/admin/bidang/edit/{id}', [SuperadminController::class, 'edit_bidang']);
    Route::post('/admin/bidang/edit/{id}', [SuperadminController::class, 'update_bidang']);
    Route::get('/admin/bidang/delete/{id}', [SuperadminController::class, 'delete_bidang']);

    Route::get('/admin/sektor', [SuperadminController::class, 'sektor']);
    Route::get('/admin/sektor/add', [SuperadminController::class, 'add_sektor']);
    Route::post('/admin/sektor/add', [SuperadminController::class, 'store_sektor']);
    Route::get('/admin/sektor/edit/{id}', [SuperadminController::class, 'edit_sektor']);
    Route::post('/admin/sektor/edit/{id}', [SuperadminController::class, 'update_sektor']);
    Route::get('/admin/sektor/delete/{id}', [SuperadminController::class, 'delete_sektor']);

    Route::get('/admin/home', [SuperadminController::class, 'home']);
    Route::get('/admin/home/filter', [SuperadminController::class, 'filter']);
    Route::post('/admin/pendaftar/{id}', [SuperadminController::class, 'detailPendaftar']);
});
Route::get('oauth/google', [LoginController::class, 'redirectToProvider'])->name('oauth.google');
Route::get('oauth/google/callback', [LoginController::class, 'handleProviderCallback'])->name('oauth.google.callback');

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/logout', function () {
    Auth::logout();
    return redirect('/');
});
