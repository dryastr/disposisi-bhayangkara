<?php

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\KarumkitController;
use App\Http\Controllers\admin\manajamen\DisposisiController;
use App\Http\Controllers\admin\manajemen\AddUsersController;
use App\Http\Controllers\admin\manajemen\LembarDisposisiKarumkitController;
use App\Http\Controllers\admin\manajemen\LembarDisposisiSpriController;
use App\Http\Controllers\admin\manajemen\LembarDisposisiUserController;
use App\Http\Controllers\admin\manajemen\NotificationController;
use App\Http\Controllers\admin\SpriController;
use App\Http\Controllers\user\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();
        if ($user->role->name === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role->name === 'spri') {
            return redirect()->route('spri.dashboard');
        } elseif ($user->role->name === 'karumkit') {
            return redirect()->route('karumkit.dashboard');
        } else {
            return redirect()->route('home');
        }
    }
    return redirect()->route('login');
})->name('home');

Auth::routes(['middleware' => ['redirectIfAuthenticated']]);


Route::middleware(['auth', 'role.admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');

    // manajemen
    Route::resource('add-users', AddUsersController::class);
    Route::resource('disposisi', DisposisiController::class);
    Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('notifications/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
});

Route::middleware(['auth', 'role.spri'])->group(function () {
    Route::get('/spri', [SpriController::class, 'index'])->name('spri.dashboard');

    // manajemen
    Route::resource('lembar-disposisi', LembarDisposisiSpriController::class);
    Route::post('/lembar-disposisi/{id}/terima', [LembarDisposisiSpriController::class, 'terima'])->name('lembar-disposisi.terima');
    Route::post('/lembar-disposisi/{id}/tolak', [LembarDisposisiSpriController::class, 'tolak'])->name('lembar-disposisi.tolak');
});

Route::middleware(['auth', 'role.karumkit'])->group(function () {
    Route::get('/karumkit', [KarumkitController::class, 'index'])->name('karumkit.dashboard');

    // manajemen
    Route::resource('lembar-disposisi-karumkit', LembarDisposisiKarumkitController::class);
    Route::post('/lembar-disposisi-karumkit/{id}/kirim', [LembarDisposisiKarumkitController::class, 'kirim'])->name('lembar-disposisi-karumkit.kirim');
});

Route::middleware(['auth', 'role.user'])->group(function () {
    Route::get('/home', [UserController::class, 'index'])->name('home');

    // manajemen
    Route::resource('lembar-disposisi-user', LembarDisposisiUserController::class);
});
