<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/',function (){
    return redirect()->route('login-page');
})->name('root');

Route::get('/user/login',['as'=>'login-page','uses'=>'UserController@loginPage']);
Route::get('/user/logout',['as'=>'logout','uses'=>'UserController@logout']);
Route::get('/user/signup',['as'=>'signup-page','uses'=>'UserController@signup']);
Route::post('/user/register',['as'=>'create-user','uses'=>'UserController@register']);
Route::post('/user/login',['as'=>'login-user','uses'=>'UserController@login']);
Route::get('/password/reset', 'UserController@showForgotPassword')->name('users.forgot-password');
Route::post('/password/email', 'UserController@sendResetEmail')->name('users.send-reset-email');
Route::get('/password/reset/{token}', 'UserController@showResetForm')->name('users.reset-password');
Route::post('/password/reset/{token}/save', 'UserController@saveResetPassword')->name('users.reset-password-save');
Route::get('users/{user_id}/profile', 'UserController@profile')->name('users.profile');
Route::post('users/{user_id}/profile', 'UserController@saveProfile')->name('users.save-profile');
Route::get('/user/confirm/{confirmation_hash}', 'UserController@confirmUser')->name('users.confirm-email');
Route::get('/user/account-unconfirmed', 'UserController@showInactiveAccount')->name('users.account-unconfirmed');
Route::post('/user/resend-confirmation-email', 'UserController@resendConfirmationEmail')->name('users.send-confirmation-mail');