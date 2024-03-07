<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RentController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RentalController;
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

    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::get('fetchall', [UserController::class, 'fetchAll'])->name('fetchAll');
    Route::get('profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/familyprofile', [FamilyProfileController::class, 'index'])->name('familyprofile.index');
    Route::post('/familyprofile/store', [FamilyProfileController::class, 'store'])->name('familyprofile.store');
    Route::get('/familyprofile/fetch',[FamilyProfileController::class, 'fetch'])->name("familyprofile.fetch");
    Route::get('/familyprofile/view', [FamilyProfileController::class, 'view'])->name('familyprofile.view');
    Route::delete('/familyprofile/delete', [FamilyProfileController::class, 'delete'])->name('familyprofile.delete');
    Route::get('/familyprofile/edit', [FamilyProfileController::class, 'edit'])->name('familyprofile.edit');
    Route::post('/familyprofile/update', [FamilyProfileController::class, 'update'])->name('familyprofile.update');

    Route::resource('products', ProductController::class);

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
    Route::delete('/room/delete', [RoomController::class, 'delete'])->name('room.delete');


});
