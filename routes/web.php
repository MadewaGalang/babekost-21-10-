<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Visitor\HomeController;
use App\Http\Controllers\Visitor\RoomController;
use App\Http\Controllers\Visitor\GalleryController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::get('/rooms', [RoomController::class, 'index'])->name('visitor.rooms');
Route::get('/rooms/{room}', [RoomController::class, 'show'])->name('visitor.rooms.show');

Route::get('/gallery', GalleryController::class)->name('visitor.gallery');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';