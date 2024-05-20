<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

$controller_path = 'App\Http\Controllers';

// Main Page Route
Route::get('/', $controller_path . '\pages\HomePage@index')->name('pages-home');
Route::get('/page-2', $controller_path . '\pages\Page2@index')->name('pages-page-2');
Route::get('/profile', $controller_path . '\pages\ProfileController@index')->name('pages-profile');
Route::post('/profile', $controller_path . '\pages\ProfileController@edit_profile')->name('edit_profile');
Route::post('/edit-password', $controller_path . '\pages\ProfileController@edit_password')->name('edit_password');

// pages
Route::get('/pages/misc-error', $controller_path . '\pages\MiscError@index')->name('pages-misc-error');

// authentication
Route::get('/auth/login-basic', $controller_path . '\authentications\LoginBasic@index')->name('auth-login-basic');
Route::post('/auth/login-basic', $controller_path . '\authentications\LoginBasic@validateform')->name('validateform');
Route::get('/auth/logout', $controller_path . '\authentications\LoginBasic@logout')->name('logout');
Route::get('/auth/register-basic', $controller_path . '\authentications\RegisterBasic@index')->name('auth-register-basic');
Route::post('/auth/register-basic', $controller_path . '\authentications\RegisterBasic@validateform_register')->name('validateform_register');


// Forgot-Password
Route::get('forget-password', $controller_path . '\authentications\ForgotPasswordController@showForgetPasswordForm')->name('forget.password.get');
Route::post('forget-password', $controller_path . '\authentications\ForgotPasswordController@submitForgetPasswordForm')->name('forget.password.post');
Route::get('reset-password/{token}', $controller_path . '\authentications\ForgotPasswordController@showResetPasswordForm')->name('reset.password.get');
Route::post('reset-password', $controller_path . '\authentications\ForgotPasswordController@submitResetPasswordForm')->name('reset.password.post');

Route::prefix('users')->group(function() use ($controller_path){
  Route::get('/', $controller_path . '\authentications\UserController@user')->name('user');
  Route::post('/getuser', $controller_path . '\authentications\UserController@getuser')->name('getuser');
  Route::get('create', $controller_path . '\authentications\UserController@create')->name('users.create');
  Route::post('store', $controller_path . '\authentications\UserController@store')->name('users.store');
  Route::get('/show/{id}', $controller_path . '\authentications\UserController@show')->name('users.show');
  Route::get('/edit/{id}', $controller_path . '\authentications\UserController@edit')->name('users.edit');
  Route::put('/update/{id}', $controller_path . '\authentications\UserController@update')->name('users.update');
  Route::get('/destroy/{id}', $controller_path . '\authentications\UserController@destroy')->name('users.destroy');
});

Route::group(['middleware' => ['auth']], function() {
  $controller_path = 'App\Http\Controllers';
  Route::get('/roles', $controller_path . '\pages\RoleController@index')->name('role.index');
  Route::get('/roles/create', $controller_path . '\pages\RoleController@create')->name('role.create');
  Route::post('/roles', $controller_path . '\pages\RoleController@store')->name('role.store');
  Route::get('/roles/{role}', $controller_path . '\pages\RoleController@show')->name('role.show');
  Route::get('/roles/{role}/edit', $controller_path . '\pages\RoleController@edit')->name('role.edit');
  Route::put('/roles/{role}', $controller_path . '\pages\RoleController@update')->name('role.update');
  Route::delete('/roles/{role}', $controller_path . '\pages\RoleController@destroy')->name('role.destroy');
  Route::post('/role/getRole', $controller_path . '\pages\RoleController@getRoles')->name('getRoles');
});


Route::get('google/login', $controller_path . '\authentications\GoogleController@redirectToGoogle')->name('google.login');
Route::get('google/callback', $controller_path . '\authentications\GoogleController@handleGoogleCallback')->name('google.login.callback');

Route::get('facebook/login', $controller_path . '\authentications\FacebookController@redirectToFacebook')->name('facebook.login');
Route::get('facebook/callback', $controller_path . '\authentications\FacebookController@handleFacebookCallback')->name('facebook.login.callback');


//polls
Route::prefix('poll')->middleware('auth')->group(function(){
  $controller_path = 'App\Http\Controllers';
  Route::view('create', 'polls.create')->name('poll.create');
  Route::post('create', $controller_path . '\pages\PollController@store')->name('poll.store');
  Route::get('/', $controller_path . '\pages\PollController@index')->name('poll.index');
  Route::get('/update/{poll}',$controller_path . '\pages\PollController@edit')->name('poll.edit');
  Route::put('/update/{poll}', $controller_path . '\pages\PollController@update')->name('poll.update');
  Route::get('delete/{poll}',$controller_path . '\pages\PollController@delete')->name('poll.delete');

  Route::get('/{poll}', $controller_path . '\pages\PollController@show')->name('poll.show');
  Route::post('/{poll}/vote',$controller_path . '\pages\PollController@vote')->name('poll.vote');
});
