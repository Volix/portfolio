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
Route::get('home', ['as' => 'home', 'uses' => 'projectsController@index']);

Route::get('project/{id}', ['uses' => 'projectsController@show', 'as' => 'projectShow']);

Route::get('slug/{slug}', ['uses' => 'projectsController@findBySlug', 'as' => 'projectShowBySlug']);

Route::group(['prefix'=>'admin'], function(){

    Route::get('/', function () {return redirect('http://google.com');});

    Route::group(['prefix'=>'projects'], function(){

        Route::get('create', ['as' => 'projectCreate', function(){
            
            return View::make('projectCreate');
            
        }]);
        
        Route::post('create', ['as' => 'projectCreate', 'uses' => 'projectsController@create']);
        
        Route::get('edit/{id}', ['as' => 'projectEdit', 'uses' => 'projectsController@edit']);
        
        Route::post('update/{id}', ['as' => 'projectUpdate', 'uses' => 'projectsController@update', 'before' => 'csrf']);
        
        Route::get('destroy/{id}', ['as' => 'projectDestory', 'uses' => 'projectsController@destroy']);
        
        Route::get('/', ['uses' => 'projectsController@manage', 'as' => 'projectManageList']);
            
    });
    
    Route::group(['prefix'=>'images'], function(){

        Route::get('upload', ['as' => 'uploadImage', function(){
            
            return View::make('projectCreate');
            
        }]);
        
        Route::post('upload', ['as' => 'imagesCreate', 'uses' => 'imagesController@create', 'before' => 'csrf']);
        
        Route::get('destroy/{id}', ['as' => 'imageDestroy', 'uses' => 'imagesController@destroy']);
        
        Route::get('/', ['uses' => 'imagesController@index', 'as' => 'imageList']);
            
    });
    
    Route::group(['prefix' => 'settings', 'before' => 'auth'], function(){
        
        Route::get('/', ['as' => 'settingsList', 'uses' => 'settingsController@index']);

        Route::get('change', ['as' => 'settingsChange', 'uses' => 'settingsController@edit']);
        
        Route::get('update', ['as' => 'settingsUpdate', 'uses' => 'settingsController@update']);
        
        Route::get('load', ['as' => 'settingsLoad', 'uses' => 'settingsController@load']);
        
    });
    
});

// Authentication routes...
Route::get('auth/login', ['as' => 'login', function(){
    return View::make('layouts.master.auth.login');
}]);
Route::post('auth/login', ['as' => 'login', 'uses' => 'Auth\AuthController@login']);
Route::get('auth/logout', ['as' => 'logout' , function() {
    if (Auth::user()){
        
        Auth::logout();
        Session::flush();
        return Redirect::to('/')->with('communication_success', ['Wylogowano pomyślnie']);
    
    }else{
        
        return Redirect::to('login')->with('communication_info', ['Aby się wylogować musisz się zalogować', 'Life is brutal']);
        
    }
}]);

// Registration routes...
Route::get('auth/register', ['as' => 'register', function () {
    return View::make('layouts.master.auth.register');
}]);
Route::post('auth/register', ['as' => 'register', 'uses' =>'Auth\AuthController@register']);
Route::filter('auth', function() {
    if (Auth::guest()){
        return Redirect::route('login');
    }
});