<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\api\QuestionController;
use App\Http\Controllers\api\TenantController;

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
//PUBLIC ROUTES
//auth
Route::post('/auth/register', [AuthController::class, 'createUser']);
Route::post('/auth/login', [AuthController::class, 'loginUser']);

//tenant
Route::post('/tenant/add', [TenantController::class, 'createTenant']);

//get user details
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::apiResource('posts', PostController::class)->middleware('auth:sanctum');

//AUTHENTICATED ROUTES
Route::group(['middleware'=>['auth:sanctum']], function(){
    //logout
    Route::post('/auth/logout',[AuthController::class,'logout']);
    //add properties
    Route::post('/properties/add', [AuthController::class, 'addProperties']);
    //add question
    Route::post('/question/getAll', [QuestionController::class, 'getAll']);   
});