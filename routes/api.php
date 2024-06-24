<?php

use App\Http\Controllers\GameController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ShelfController;
use App\Http\Controllers\TripRequestController;
use App\Http\Middleware\DummyAuthMiddleware;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/create_user',[UsersController::class,'create_user'])->middleware(DummyAuthMiddleware::class);

Route::get('/get_user/{user_id}', [UsersController::class, 'get_user']);

Route::delete('/delete_user/{user_id}',[UsersController::class,'softdeleteuser'])->middleware(DummyAuthMiddleware::class);

Route::patch('/update_user_phone/{user_id}',[UsersController::class,'update_user_phone']);

Route::post('/create_trip',[TripRequestController::class,'create_trip']);

Route::delete('/delete_trip/{id}',[TripRequestController::class,'delete_trip']);

Route::put('/update_trip/{id}',[TripRequestController::class,'update_trip']);

Route::get('/get_trip/{id}',[TripRequestController::class,'get_trip']);


















Route::post('/create_shelf',[ShelfController::class,'create_shelf'])->middleware(DummyAuthMiddleware::class);

Route::post('/assign_books',[ShelfController::class,'assign_books'])->middleware(DummyAuthMiddleware::class);

Route::get('/get_shelf/{id}',[ShelfController::class,'get_shelf'])->middleware(DummyAuthMiddleware::class);

Route::get('/get_shelves',[ShelfController::class,'getshelves'])->middleware(DummyAuthMiddleware::class);

Route::get('/users',[UsersController::class,'getusers'])->middleware(DummyAuthMiddleware::class);


Route::post('/game',[GameController::class,'createGame']);
Route::post('/game/{game}/player/{player}/roll',[GameController::class,'rollDice']);
