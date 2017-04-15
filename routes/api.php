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

Route::post('application', ['uses'=>'ApplicationController@create']);

Route::get('application/leaderboard/{leaderboard_id}', ['uses'=>'LeaderboardController@getLeaderboardScores']);
Route::post('application/leaderboard/{leaderboard_id}/score', ['uses'=>'LeaderboardController@updateScore']);
Route::post('application/leaderboard', ['uses'=>'LeaderboardController@create']);


Route::post('application/user/login',['uses'=>'AppUserController@login']);
Route::post('application/user',['uses'=>'AppUserController@create']);
Route::post('application/user/update',['uses'=>'AppUserController@update']);
Route::get('application/user/me',['uses'=>'AppUserController@getMe']);