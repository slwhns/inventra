<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\OrderController;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/home', function () {
    return view('user.home');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

require __DIR__.'/auth.php';

// Product routes using resource controller, excluding 'show' since it's not used..
Route::resource('products', ProductController::class)->except(['show']);




Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index'); // Main view
Route::post('/inventory', [InventoryController::class, 'store'])->name('inventory.store');
Route::get('/inventory/{inventory}/edit', [InventoryController::class, 'edit'])->name('inventory.edit');
Route::put('/inventory/{inventory}', [InventoryController::class, 'update'])->name('inventory.update');
Route::delete('/inventory/{inventory}', [InventoryController::class, 'destroy'])->name('inventory.destroy');
Route::get('/inventory/history', [InventoryController::class, 'history'])->name('inventory.history');
Route::post('/inventory/update-stock', [InventoryController::class, 'updateStock'])->name('inventory.updateStock');
Route::get('/inventory/search', [InventoryController::class, 'search'])->name('inventory.search');





Route::prefix('products/{product}')->group(function () {
    Route::get('colors', [ColorController::class, 'index'])->name('colors.index');
    Route::post('colors', [ColorController::class, 'store'])->name('colors.store');
    Route::delete('colors/bulk-delete', [ColorController::class, 'bulkDelete'])->name('colors.bulkDelete');
    Route::post('colors/adjust-price', [ColorController::class, 'adjustPrice'])->name('colors.adjustPrice');
});







Route::get('/colour', function () {
    return view('user.colour');
})->name('colour');

Route::get('/Kalersheild', function () {
    return view('user.kalersheild');
})->name('kalersheild');

Route::get('/Supercoat', function () {
    return view('user.supercoat');
})->name('supercoat');

Route::get('/Maxicoat', function () {
    return view('user.maxicoat');
})->name('maxicoat');

Route::get('/MaxicoatLite', function () {
    return view('user.maxicoatlite');
})->name('maxicoatlite');

Route::get('/Glomel', function () {
    return view('user.glomel');
})->name('glomel');

Route::get('/details', function () {
    return view('user.details');
})->name('details');

Route::post('/details', [OrderController::class, 'store'])->name('order.details');