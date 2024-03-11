<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RentController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FamilyProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {

    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {


    Route::get('/all-record',[HomeController::class, 'get_record'])->name("get.record");

    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::get('fetchall', [UserController::class, 'fetchAll'])->name('fetchAll');
    Route::get('profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/apartment', [RentController::class, 'index'])->name('apartment.index');
    Route::post('/apartment/store', [RentController::class, 'store'])->name('apartment.store');
    Route::get('/apartment/fetch',[RentController::class, 'fetch'])->name("apartment.fetch");
    Route::get('/apartment/edit', [RentController::class, 'edit'])->name('apartment.edit');
    Route::post('/apartment/update', [RentController::class, 'update'])->name('apartment.update');
    Route::delete('/apartment/delete', [RentController::class, 'delete'])->name('apartment.delete');

    Route::get('/room', [RoomController::class, 'index'])->name('room.index');
    Route::post('/room/store', [RoomController::class, 'store'])->name('room.store');
    Route::get('/room/fetch',[RoomController::class, 'fetch'])->name("room.fetch");
    Route::get('/room/edit', [RoomController::class, 'edit'])->name('room.edit');
    Route::post('/room/update', [RoomController::class, 'update'])->name('room.update');
    // Route::delete('/room/delete', [RoomController::class, 'delete'])->name('room.delete');
    Route::get('/get-available-rooms', [RentController::class, 'getAvailableRooms'])->name('get.available.rooms');

    Route::get('/archive', [ArchiveController::class, 'index'])->name('archive.index');
    Route::get('/archive/trashed',[ArchiveController::class, 'trashed_data'])->name("archive.trashed");
    Route::delete('/archive/force-delete', [ArchiveController::class, 'delete'])->name('archive.delete');
    Route::post('/archive/force-restore', [ArchiveController::class, 'restore'])->name('archive.restore');

});
