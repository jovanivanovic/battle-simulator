<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/games', 'GameController@list'); // List all games
Route::post('/games', 'GameController@create'); // Create a new game
Route::get('/games/{game}', 'GameController@get'); // Return a specific game log
Route::post('/games/{game}/armies', 'GameController@addArmy'); // Add a new army to a game
Route::post('/games/{game}/attack', 'GameController@attack'); // Run the attack
Route::post('/games/{game}/reset', 'GameController@reset'); // Reset the game
