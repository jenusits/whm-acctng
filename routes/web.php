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


Route::get('/charts', 'ChartsController@index')->name('charts');
Route::get('/charts/create', 'ChartsController@create')->name('charts.create');
Route::post('/charts', 'ChartsController@store')->name('charts.store');
Route::get('/charts/{chart}/edit', 'ChartsController@edit')->name('charts.edit');
Route::post('/charts/{id}', 'ChartsController@update')->name('charts.update');
Route::delete('/charts/{chart}', 'ChartsController@destroy')->name('charts.destroy');
Route::get('/charts/{chart}', 'ChartsController@show')->name('charts.show');


Route::get('/request_funds', 'RequestFundsController@index')->name('request_funds');
Route::get('/request_funds/create', 'RequestFundsController@create')->name('request_funds.create');
Route::post('/request_funds', 'RequestFundsController@store')->name('request_funds.store');
Route::get('/request_funds/{request_fund}', 'RequestFundsController@edit')->name('request_funds.edit');
Route::post('/request_funds/{request_fund}', 'RequestFundsController@update')->name('request_funds.update');
Route::delete('/request_funds/{request_funds}', 'RequestFundsController@destroy')->name('request_funds.destroy');
Route::get('/request_funds/{chart}', 'RequestFundsController@show')->name('request_funds.show');
