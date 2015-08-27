<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'projectsController@index');

Route::get('project/{id}', 'projectsController@show');

Route::get('slug/{slug}', 'projectsController@findBySlug');

Route::group(['prefix'=>'admin'], function(){

    Route::get('/', function () {return redirect('http://google.com');});

    Route::group(['prefix'=>'projects'], function(){

        Route::get('create', ['as' => 'projectCreate', function(){
            
            return View::make('projectCreate');
            
        }]);
        
        Route::post('create', ['as' => 'projectCreate', 'uses' => 'projectsController@create', 'before' => 'csrf']);
        
        Route::get('edit/{id}', ['as' => 'projectEdit', 'uses' => 'projectsController@edit']);
        
        Route::post('update/{id}', ['as' => 'projectUpdate', 'uses' => 'projectsController@update', 'before' => 'csrf']);
        
        Route::get('destroy/{id}', ['as' => 'projectDestory', 'uses' => 'projectsController@destroy']);
        
        Route::get('/', ['uses' => 'projectsController@manage', 'as' => 'projectManageList']);
            
    });
    
    Route::group("settings", function(){
        
        Route::get('/', ['as' => 'settingsList', 'uses' => 'settingsController@index']);

        Route::get('change', ['as' => 'settingsChange', 'uses' => 'settingsController@edit']);
        
        Route::get('update', ['as' => 'settingsUpdate', 'uses' => 'settingsController@update']);
		
		Route::get('load', ['as' => 'settingsLoad', 'uses' => 'settingsController@load']);
        
    });
    
});

// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');

