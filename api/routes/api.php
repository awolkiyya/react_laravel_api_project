<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Controller;

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
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/logout', [AuthController::class, 'logout']);
    Route::get('/getmydata',[AuthController::class,'getMyData']);
    Route::post('/likePost',[Controller::class,'storeLike']);
    Route::post('/postComment',[Controller::class,'postComment']);
});
//  now define the list of the route
Route::post('/signup',[AuthController::class,'signup']); // this is for the 
Route::get('/logout',[AuthController::class,'logout']); 

// now work in post process
Route::get('/getAllPost',[Controller::class,'getAllPost']);
Route::get('/getPost/{id}',[Controller::class,'getPost']);
Route::get('/getByCatagore/{id}',[Controller::class,'getByCatagore']);


