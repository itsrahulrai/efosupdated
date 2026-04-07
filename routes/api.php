<?php

use App\Http\Controllers\Api\StudentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
 */

Route::middleware('auth:sanctum')->get('/user', function (Request $request)
{
    return $request->user();
});

/*
|--------------------------------------------------------------------------
| Student Registration API
|--------------------------------------------------------------------------
 */

Route::post('/student-register', [StudentController::class, 'store']);
