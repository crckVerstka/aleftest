<?php

use App\Http\Controllers\Api\v1\GroupController;
use App\Http\Controllers\Api\v1\LectureController;
use App\Http\Controllers\Api\v1\PlanController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Api\v1\StudentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('/v1')->group(function () {
    Route::resource('students', StudentController::class)->except(['create', 'edit']);
    Route::resource('groups', GroupController::class)->except(['create', 'edit']);
    Route::resource('lectures', LectureController::class)->except(['create', 'edit']);
    Route::get('/plan/{group_id}', [PlanController::class, 'plan'])->name('plan');
    Route::post('/plan-create', [PlanController::class, 'createOrUpdatePlan'])->name('plan.create');
});
