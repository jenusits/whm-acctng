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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('charts','ChartsController');

Route::resource('request_funds', 'RequestFundsController', 
    [
        'parameters' => [
            'create' => 'type'
        ]
    ]
);
// Route::get('request_funds/mult', 'RequestFundsController@approval')->name('request_funds.approval');
// Route::get('request_funds/approval', 'RequestFundsController@approval')->name('request_funds.approval');
// Route::patch('request_funds/{id}/approve', 'RequestFundsController@approve')->name('request_funds.approve');

