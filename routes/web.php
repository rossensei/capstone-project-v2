<?php

use App\Models\Item;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Facility;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\UserWithItemsController;
use App\Http\Controllers\FacultyRequestController;
use App\Http\Controllers\FacilityPropertyController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return Inertia::render('Welcome');
// });

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard', [
        'users' => User::count(),
        'facilities' => Facility::count(),
        'items' => Item::count(),
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/facilities', [FacilityController::class, 'index'])->name('facilities.index');
    Route::get('/facilities/create', [FacilityController::class, 'create'])->name('facilities.create');
    Route::get('/facilities/{facility}/view-properties', [FacilityPropertyController::class, 'index']);
    Route::get('/facilities/edit/{facility}', [FacilityController::class, 'edit'])->name('facilities.edit');
    Route::patch('/facilities/{facility}', [FacilityController::class, 'update'])->name('facilities.update');
    Route::post('/facilities', [FacilityController::class, 'store'])->name('facilities.store');
    Route::delete('/facilities/remove-facility/{facility}', [FacilityController::class, 'destroy'])->name('facilities.destroy');

    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/edit/{user}', [UserController::class, 'edit'])->name('users.edit');
    Route::patch('/users/{user}', [UserController::class, 'update']);
    Route::post('/users/toggle-active/{user}', [UserController::class, 'toggleActive']);
    Route::patch('/users/update-role/{user}', [UserController::class, 'updateRole'])->middleware('role:admin');
    Route::patch('/users/update-password/{user}', [UserController::class, 'updatePassword'])->middleware('role:admin');
    Route::delete('/users/delete/{user}', [UserController::class, 'destroy']);

    Route::get('/items', [ItemController::class, 'index'])->name('item.index');
    Route::get('/items/add-item', [ItemController::class, 'create'])->name('item.create');
    Route::post('/items', [ItemController::class, 'store'])->name('item.store');
    Route::get('/items/edit/{item}', [ItemController::class, 'edit'])->name('item.edit');
    Route::put('/items/{item}', [ItemController::class, 'update'])->name('item.update');
    Route::delete('/items/delete-item/{item}', [ItemController::class, 'destroy'])->name('item.destroy');
    Route::delete('/items/delete-items', [ItemController::class, 'bulkDelete']);

    Route::get('/properties', [PropertyController::class, 'index'])->name('property.index');

    Route::get('/request-items', [FacultyRequestController::class, 'index']); //test endpoint


    Route::get('/item-usages', [UserWithItemsController::class, 'index']);


    Route::get('/test', function () {
        return Inertia::render('TestPage');
    })->name('test');
});

require __DIR__.'/auth.php';
