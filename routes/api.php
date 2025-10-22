<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DesignController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Design API Routes
Route::prefix('design')->group(function () {
    // Save or submit design
    Route::post('/save', [DesignController::class, 'saveDesign']);
    
    // Get specific design
    Route::get('/{id}', [DesignController::class, 'getDesign']);
    
    // Get all designs (for dashboard)
    Route::get('/', [DesignController::class, 'getAllDesigns']);
});

// Public routes (no authentication required for form submission)
Route::post('/save-design', [DesignController::class, 'saveDesign']);

// Upload design route (alias for save-design)
Route::post('/upload-design', [DesignController::class, 'saveDesign']);
