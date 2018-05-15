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

/* Route::get('/', function () {
    return view('welcome');
}); */

Route::get('/', function() {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('charts','ChartsController');

Route::resource('request_funds', 'Disbursement\RequestFunds\RequestFundsController');
Route::get('api/particulars/{id}', function($id) {
    $p = App\Request_funds::find($id);
    return response()->json($p->particulars);    
});

Route::resource('users', 'UserController');

Route::resource('roles', 'RolesController')->except(['show']);

Route::resource('permissions', 'PermissionsController')->except(['show', 'edit']);

Route::resource('expenses', 'ExpensesController');

Route::resource('bank', 'BankController');

Route::resource('payment_method', 'PaymentMethodController');
// Route::get('request_funds/mult', 'RequestFundsController@approval')->name('request_funds.approval');
// Route::get('request_funds/approval', 'RequestFundsController@approval')->name('request_funds.approval');
// Route::patch('request_funds/{id}/approve', 'RequestFundsController@approve')->name('request_funds.approve');

