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

Route::get('/', function () {
    return view('welcome');
});

# Panel #
Route::get('/levels/', 
    ['as' => 'levels.list', 'uses' => 'LevelsController@index']);
Route::get('/levels/create/', 
    ['as' => 'levels.create', 'uses' => 'LevelsController@form']);
Route::post('/levels/create/', 
    ['as' => 'levels.store', 'uses' => 'LevelsController@store']);
Route::get('/levels/edit/{id}/', 
    ['as' => 'levels.edit', 'uses' => 'LevelsController@form']);
Route::post('/levels/edit/', 
    ['as' => 'levels.update', 'uses' => 'LevelsController@update']);
# End Panel #

Route::get('/api/users/',
    ['uses' => 'UsersController@index']
);
Route::get('/api/users/{userId}/',
    ['uses' => 'UsersController@show']
);
/*Route::get('/api/levels/',
    ['uses' => 'LevelsController@index']
);
Route::get('/api/levels/{levelId}/', 
    ['uses' => 'LevelsController@show']
);*/
Route::get('/api/games/', 
    ['uses' => 'GamesController@index']);
Route::post('/api/games/insert/',
    ['uses' => 'GamesController@store']);