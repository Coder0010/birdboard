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
// class Car
// {
//     public static function model()
//     {
//         self::getModel();
//     }

//     protected static function getModel()
//     {
//         echo "I am a Car!";
//     }
// }

// class Mercedes extends Car
// {
//     protected static function getModel()
//     {
//         echo "I am a Mercedes!";
//     }
// }
// Car::model();
// echo("\n");
// Mercedes::model();

Route::get('/', function () {
    return redirect()->route('home');
});

Auth::routes();

Route::get('home', 'HomeController@index')->name('home');

Route::resource('projects', 'ProjectController');

Route::post('projects/{project}/tasks', 'TaskController@store')->name('tasks.store');
Route::patch('projects/{project}/tasks/{task}', 'TaskController@update')->name('tasks.update');
