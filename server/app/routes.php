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

  //Route model bindings
  Route::model('state', 'Dining\Models\State');
  Route::model('town', 'Dining\Models\Town');
  Route::model('user', 'Dining\Models\User');
  Route::model('tutor', 'Dining\Models\Tutor');

  Route::get('test', function() {
	return ["status" => "alive"];
  });
 d
  Route::post('login', 'Dining\Controllers\LoginController@login');

// Student routes 
  Route::get('student/{id}', 'Dining\Controllers\StudentController@get')->where('id', '[0-9]+');


  
  // Job routes
   Route::post('job', 'Dining\Controllers\JobController@postJob');
   Route::post('job/{id}/delete', 'Dining\Controllers\JobController@deleteJob');
   Route::get('job', 'Dining\Controllers\JobController@query');
 
// Tutor routes
  Route::get('tutor/{id}', 'Dining\Controllers\TutorController@get');
  Route::post('tutor/{id}/update/profile', 'Dining\Controllers\TutorController@update')->where('id', '[0-9]+');
  Route::post('tutor/{id}/update/subject', 'Dining\Controllers\TutorController@updateSubject')->where('id', '[0-9]+');


  Route::post('tutor/{tutor}/subjects', 'Dining\Controllers\TutorController@updateSubject')->where('id', '[0-9]+');
  Route::post('tutor/{id}/remove/subject', 'Dining\Controllers\TutorController@removesubject')->where('id', '[0-9]+');
  Route::post('tutor/{tutor}/agreetoterms', 'Dining\Controllers\TutorController@updateagreetoterms')->where('id', '[0-9]+');
  Route::post('tutor/{id}/subject/{id1}/rate', 'Dining\Controllers\TutorController@updatesubjectrate')->where('id', '[0-9]+')->where('id1', '[0-9]+');

  // Route::post('tutor/{id}/subject', 'Dining\Controllers\Tutor\SubjectController@create');
  // Route::post('tutor/{id}/subject', 'Dining\Controllers\Tutor\SubjectController@create');
  // Route::post('tutor/{id}/subject', 'Dining\Controllers\Tutor\SubjectController@create');


  /* Route::post('tutor/create', 'Dining\Controllers\Tutor\SignupController@create');
    Route::post('tutor/signup/profile/{id}', 'Dining\Controllers\Tutor\SignupController@addProfileInformation')->where('id', '[0-9]+');
    Route::post('tutor/signup/personalize/{id}', 'Dining\Controllers\Tutor\SignupController@personalize')->where('id', '[0-9]+');
    Route::post('tutor/signup/terms/{id}', 'Dining\Controllers\Tutor\SignupController@agreeToTerms')->where('id', '[0-9]+');
   */

// User routes 
  Route::post('user', 'Dining\Controllers\UserController@signup');
  Route::post('user/{id}', 'Dining\Controllers\UserController@update')->where('id', '[0-9]+');
  Route::get('user/{id}', 'Dining\Controllers\UserController@get')->where('id', '[0-9]+');
  Route::get('user', 'Dining\Controllers\UserController@getByEmail');
  Route::get('user/{email}', 'Dining\Controllers\UserController@getByEmail');
  Route::post('user/{id}', 'Dining\Controllers\UserController@update')->where('id', '[0-9]+');
  Route::post('user/{id}/picture', 'Dining\Controllers\UserController@update')->where('id', '[0-9]+');

  Route::post('user/activationmail/{user}', 'Dining\Controllers\UserController@sendActivationMail');

  Route::post('user/activate', 'Dining\Controllers\UserController@activate');
  Route::post('user/changepassword', 'Dining\Controllers\User\PasswordController@changePassword');
  Route::post('user/resetpassword/1', 'Dining\Controllers\User\PasswordController@sendResetPasswordInstruction');
  Route::post('user/resetpassword/2', 'Dining\Controllers\User\PasswordController@completeResetPassword');
  Route::get('users', 'Dining\Controllers\UserController@index');

  Route::get('user/{id}/upload/picture', function() {
	return View::make('test');
  });
  Route::post('user/{user}/upload/picture', 'Dining\Controllers\UserController@uploadPicture');

// Subject routes 
  Route::get('subject/by_name', 'Dining\Controllers\SubjectController@getSubjectByName');
  Route::get('subject/{id}', 'Dining\Controllers\SubjectController@get')->where('id', '[0-9]+');
  Route::get('subject', 'Dining\Controllers\SubjectController@all');
  Route::get('subject/{id}/delete', 'Dining\Controllers\SubjectController@delete')->where('id', '[0-9]+');
  Route::post('subject', 'Dining\Controllers\SubjectController@create');

// Subject Category routes 
  Route::get('category/{id}', 'Dining\Controllers\CategoryController@get')->where('id', '[0-9]+');
  Route::get('category', 'Dining\Controllers\CategoryController@all');
  Route::get('category/{id}/delete', 'Dining\Controllers\CategoryController@delete')->where('id', '[0-9]+');
  Route::get('category/{id}/subject', 'Dining\Controllers\CategoryController@getSubjects')->where('id', '[0-9]+');
  Route::post('category', 'Dining\Controllers\CategoryController@create');
  Route::post('category/subject', 'Dining\Controllers\CategoryController@addSubject')->where('subjectid', '[0-9]+')->where('categoryid', '[0-9]+');

  //Location routes
  Route::get('location/state', 'Dining\Controllers\LocationController@states');
  Route::get('location/state/{state}/towns', 'Dining\Controllers\LocationController@townsInState')->where('state', '[0-9]+');
  Route::get('location/town/{town}/areas', 'Dining\Controllers\LocationController@areasInTown')->where('town', '[0-9]+');

  // Search routes
  Route::get('search/tutors', 'Dining\Controllers\SearchController@tutors');
  Route::get('search/jobs', 'Dining\Controllers\SearchController@jobs');




// User routes 
  Route::post('user', 'Dining\Controllers\UserController@signup');
  Route::post('user/{id}', 'Dining\Controllers\UserController@update')->where('id', '[0-9]+');
  Route::get('user/{id}', 'Dining\Controllers\UserController@get')->where('id', '[0-9]+');
  Route::post('user/{id}', 'Dining\Controllers\UserController@update')->where('id', '[0-9]+');
  Route::post('user/{id}/picture', 'Dining\Controllers\UserController@update')->where('id', '[0-9]+');

  Route::get('user/activationmail/{id}', 'Dining\Controllers\UserController@sendactivationmail')->where('id', '[0-9]+');
  Route::post('user/activate', 'Dining\Controllers\UserController@activate');
  Route::post('user/changepassword', 'Dining\Controllers\User\PasswordController@changePassword');
  Route::post('user/resetpassword/1', 'Dining\Controllers\User\PasswordController@sendResetPasswordInstruction');
  Route::post('user/resetpassword/2', 'Dining\Controllers\User\PasswordController@completeResetPassword');

  Route::get('user/{id}/upload/picture', function() {

	return View::make('test');
  });
  Route::post('user/{id}/upload/picture', 'Dining\Controllers\UserController@updatePicture')->where('id', '[0-9]+');

// Subject routes 
  Route::get('subject/by_name', 'Dining\Controllers\SubjectController@getSubjectByName');
  Route::get('subject/{id}', 'Dining\Controllers\SubjectController@get')->where('id', '[0-9]+');
  Route::get('subject', 'Dining\Controllers\SubjectController@all');
  Route::get('subject/{id}/delete', 'Dining\Controllers\SubjectController@delete')->where('id', '[0-9]+');
  Route::post('subject', 'Dining\Controllers\SubjectController@create');

// Subject Category routes 
  Route::get('category/{id}', 'Dining\Controllers\CategoryController@get')->where('id', '[0-9]+');
  Route::get('category', 'Dining\Controllers\CategoryController@all');
  Route::get('category/{id}/delete', 'Dining\Controllers\CategoryController@delete')->where('id', '[0-9]+');
  Route::get('category/{id}/subject', 'Dining\Controllers\CategoryController@getSubjects')->where('id', '[0-9]+');
  Route::post('category', 'Dining\Controllers\CategoryController@create');
  Route::post('category/subject', 'Dining\Controllers\CategoryController@addSubject')->where('subjectid', '[0-9]+')->where('categoryid', '[0-9]+');

  //Location routes
  Route::get('location/state', 'Dining\Controllers\LocationController@states');
  Route::get('location/state/{state}/towns', 'Dining\Controllers\LocationController@townsInState')->where('state', '[0-9]+');
  Route::get('location/town/{town}/areas', 'Dining\Controllers\LocationController@areasInTown')->where('town', '[0-9]+');

  // Search routes
  Route::get('search/tutors', 'Dining\Controllers\SearchController@tutors');

  //Student Tutor Request
  Route::post('student/{id}/job', 'Dining\Controllers\JobController@createStudentJob')->where('id', '[0-9]+');
  Route::post('student/{id}/job/{id1}', 'Dining\Controllers\JobController@updateStudentJob')->where('id', '[0-9]+')->where('id1', '[0-9]+');
  Route::post('student/{id}/remove/job/{id1}', 'Dining\Controllers\JobController@removeStudentJob')->where('id', '[0-9]+')->where('id1', '[0-9]+');


  // Message
  Route::get('user/{id}/mail/{filter?}', 'Dining\Controllers\MessageController@getMessages')->where('id', '[0-9]+');
  Route::get('user/{id}/mail/search/{filter?}', 'Dining\Controllers\MessageController@search')->where('id', '[0-9]+');
  Route::post('user/{id}/mail', 'Dining\Controllers\MessageController@createMessage')->where('id', '[0-9]+');
  /* Route::delete('user/{id}/mail/{mail_type}/{mail_id}', 
		'Dining\Controllers\MessageController@deleteMessage')
		->where(['id' => '[0-9]+', 'mail_type' => 'inbox|sent',
			'mail_id' =>'[0-9]+']);*/
   Route::post('user/{id}/mail/delete/{mail_type}', 
		'Dining\Controllers\MessageController@deleteMessages')
		->where(['id' => '[0-9]+', 'mail_type' => 'inbox|sent']);
});



Route::get('/', function() {
  //$student = Dining\Models\Student::create(array('id' => 54, "current_balance"=>300)); 
  return ["status" => "alive"];
});
Route::get('/hello', function() {
  //$student = Dining\Models\Student::create(array('id' => 54, "current_balance"=>300)); 
  return App::environment();
  return ["status" => "alive"];
});
App::missing(function($exception) {
  return Response::json(array("status" => "error", "message" => "Invalid API Call"));
});
