<?php

use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\LeadController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/projects', [ProjectController::class, 'index']);
Route::get('/types', [ProjectController::class, 'getTypes']);
Route::get('/technologies', [ProjectController::class, 'getTechnologies']);
Route::get('/project-by-slug/{slug}', [ProjectController::class, 'getProjectBySlug']);

Route::post('/send-email', [LeadController::class, 'store']);
