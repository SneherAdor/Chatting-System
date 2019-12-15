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


Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('/', function () {
    return view('welcome');
	});

	Route::get('users', function() {
	    return view('admin.users.index');
	});
});



// Authentication Route           
Auth::routes(['verify' => true]);


// Role and Permissions Route           
Route::group(['namespace' => 'Admin', 'middleware' => ['auth', 'verified']], function () {

    Route::get('roles', 'RoleController@index');
	Route::post('roles/store', 'RoleController@store');
	Route::get('roles/create', 'RoleController@create');
	Route::get('roles/edit/{id}', 'RoleController@edit');
	Route::post('roles/update/{id}', 'RoleController@update');
	Route::delete('roles/delete/{id}', 'RoleController@destroy');
	Route::post('roles/role-name-check-on-add', 'RoleController@roleUniqueCheckOnAdd');
	Route::post('roles/role-name-check-on-edit', 'RoleController@roleUniqueCheckOnEdit');

});



//Users Route            
Route::group(['namespace' => 'Admin', 'middleware' => ['auth', 'verified']], function () {
    Route::get('users', 'UserController@index');
	Route::post('users/store', 'UserController@store');
	Route::get('users/create', 'UserController@create');
	Route::get('users/edit/{id}', 'UserController@edit');
	Route::get('users/profile/{id}', 'UserController@profile');
	Route::post('users/update/{id}', 'UserController@update');
	Route::get('users/delete/{id}', 'UserController@destroy');

	Route::post('users/email-check-on-add', 'UserController@emailUniqueCheckOnAdd');
	Route::post('users/email-check-on-update', 'UserController@emailUniqueCheckOnUpdate');
});




// Activities Route            
Route::group(['namespace' => 'Admin', 'middleware' => ['auth', 'verified']], function () {
    Route::get('activities', 'ActivityController@index');
});



//Settings Route            
Route::group(['namespace' => 'Admin', 'middleware' => ['auth', 'verified']], function () {
    Route::get('settings/general', 'GeneralSettingController@edit');
    Route::post('settings/general/update/{id}', 'GeneralSettingController@update');

    Route::get('settings/login-url', 'OptionSettingsController@editloginurl');
    Route::post('settings/login-url/update/{id}', 'OptionSettingsController@updateloginurl');


    Route::get('settings/options', 'OptionSettingsController@options');
    Route::post('settings/options/update', 'OptionSettingsController@optionsUpdate');

    Route::get('settings/github', 'OptionSettingsController@githuboauth');
    Route::get('settings/facebook', 'OptionSettingsController@facebookoauth');
    Route::get('settings/google', 'OptionSettingsController@googleoauth');
    Route::post('settings/oauth/update/{id}', 'OptionSettingsController@updateoauth');


    Route::get('settings/mail', 'MailSetupController@mail');
    Route::post('settings/mail/update/{id}', 'MailSetupController@updateMail');
});



//Social Login Route        
Route::get('login/{provider}', 'Auth\LoginController@redirectToProvider')->middleware('oauth');
Route::get('login/{provider}/callback', 'Auth\LoginController@handleProviderCallback')->middleware('oauth');



// User Registration Route
Route::get('users/registration', 'Admin\UserController@registration');
Route::post('registration/store', 'Admin\UserController@registrationStore');


// Chat message
Route::get('chat/{user_id}', 'Admin\ChatController@index');
Route::get('chat-agent', 'Admin\ChatController@agent');
Route::get('chat-box', 'Admin\ChatController@chatBox');
Route::post('chat-send', 'Admin\ChatController@send');
