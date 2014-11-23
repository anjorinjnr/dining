<?php

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the Closure to execute when that URI is requested.
  |
 */


Route::group(['prefix' => 'v1'], function() {

  Route::model('user', 'Chefme\Models\User');

  Route::post('login', 'Chefme\Controllers\LoginController@login');

// User routes 
  Route::post('user', 'Chefme\Controllers\UserController@signup');
  Route::post('user/{id}', 'Chefme\Controllers\UserController@update')->where('id', '[0-9]+');
  Route::get('user/{id}', 'Chefme\Controllers\UserController@get')->where('id', '[0-9]+');
  Route::get('user', 'Chefme\Controllers\UserController@getByEmail');
  Route::get('user/{email}', 'Chefme\Controllers\UserController@getByEmail');
  Route::post('user/{id}', 'Chefme\Controllers\UserController@update')->where('id', '[0-9]+');
  Route::post('user/{id}/picture', 'Chefme\Controllers\UserController@update')->where('id', '[0-9]+');

  Route::post('user/activationmail/{user}', 'Chefme\Controllers\UserController@sendActivationMail');

  Route::post('user/activate', 'Chefme\Controllers\UserController@activate');
  Route::post('user/changepassword', 'Chefme\Controllers\User\PasswordController@changePassword');
  Route::post('user/resetpassword/1', 'Chefme\Controllers\User\PasswordController@sendResetPasswordInstruction');
  Route::post('user/resetpassword/2', 'Chefme\Controllers\User\PasswordController@completeResetPassword');
  Route::get('users', 'Chefme\Controllers\UserController@index');

  Route::get('user/{id}/upload/picture', function() {
	return View::make('test');
  });
  Route::post('user/{user}/upload/picture', 'Chefme\Controllers\UserController@uploadPicture');

});


 Route::post('login', 'Chefme\Controllers\LoginController@login');
Route::get('/', function() {
  //$student = Chefme\Models\Student::create(array('id' => 54, "current_balance"=>300)); 
  return ["status" => "alive here"];
});

Route::get('/log', function() {
  //$student = Chefme\Models\Student::create(array('id' => 54, "current_balance"=>300)); 
  return ["status" => "log here"];
});

App::missing(function($exception) {
  return Response::json(array("status" => "error", "message" => "Invalid API Call"));
});
