<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DesignController;

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

// Dashboard route
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// Importers registration form
Route::get('/importers/register', function () {
    return view('importers.form');
})->name('importers.register');

// Handle form submission
Route::post('/importers/register', function () {
    // This will be handled by the API endpoint
    return redirect()->route('dashboard');
})->name('importers.register.submit');