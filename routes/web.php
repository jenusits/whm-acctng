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
    return redirect('login');
    return view('auth.login');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {

    Route::get('/home', 'HomeController@index')->name('home');

    Route::resource('charts','ChartsController');
    
    // Route::resource('request_funds', 'Disbursement\RequestFunds\RequestFundsController');
    Route::resource('expenses', 'Disbursement\ExpensesController');
        Route::get('expenses/print/{id}', 'Disbursement\ExpensesController@print');
    
    Route::get('/api/particulars/{type}/{id}', function($type = 'request_funds', $id) {
        /* if ($type == 'request_funds')
            $p = App\Request_funds::find($id);
        else */ 
        if ($type == 'expenses')
            $p = App\Expenses::find($id);
        else
            $p = null;
    
        if (null !== $p)
            return response()->json($p->particulars);    
        else
            return response()->json(false);
    });
    
    Route::resource('users', 'UserController');
    Route::resource('roles', 'RolesController')->except(['show']);
    Route::resource('permissions', 'PermissionsController')->except(['show', 'edit']);
    Route::resource('bank', 'BankController');
    Route::resource('payment_method', 'PaymentMethodController');
    
    Route::get('/api/banks/{id}', function($id) {
        return \App\Bank::findOrFail($id);
    });
    
    Route::resource('payee', 'PayeeController');
    
    Route::get('samp/{id}', function($id) {
        $expense = \App\Expenses::findOrFail($id);
        $particulars = $expense->particulars;
        return view('layouts.vouchers.voucher', compact('expense', 'particulars'));
    });
    
    Route::resource('check', 'Disbursement\CheckController');
        Route::get('check/print/{id}', 'Disbursement\CheckController@print');
    
    Route::resource('bill', 'Disbursement\BillController');
    Route::resource('pay-bills', 'Disbursement\PayBillController');
    
    Route::get('settings', 'SettingsController@edit')->name('settings.index');
    Route::put('settings', 'SettingsController@update')->name('settings.update');

    Route::resource('admin-settings', 'AdminSettingsController');

    Route::resource('purchase_order', 'Disbursement\PurchaseOrderController');

    Route::resource('employees', 'Employees\EmployeesController');

    // Route::resource('payroll', 'PayrollController');
    Route::get('/payroll', 'PayrollController@index')->name('payroll.index');
    Route::get('/payroll/create/{id}', 'PayrollController@create')->name('payroll.create');
    Route::post('/payroll', 'PayrollController@store')->name('payroll.store');
    Route::get('/employee/{id}/payroll', 'PayrollController@show')->name('payroll.show');
    Route::get('/payroll/{payroll}/edit', 'PayrollController@edit')->name('payroll.edit');
    Route::put('/payroll/{payroll}/update', 'PayrollController@update')->name('payroll.update');
    Route::delete('/payroll/{payroll}', 'PayrollController@destroy')->name('payroll.destroy');

});
        
Route::get('real-time', function() {
    return [
        'date' => \Carbon\Carbon::now()->format('M d, Y'),
        'time' => \Carbon\Carbon::now()->format('H:i:s'),
    ];
});

Route::get('timelog/', function() {
    return view('timelog.form');
})->name('timelog');

Route::post('employee/check', /* 'Employees\EmployeesController@check' */function() {

    var_dump(request()->all());
    $id = null !== request('employee_id') ? request('employee_id') : 0;
    $emp = \App\Employees::where('employee_id', $id);

    echo json_encode($emp);
})->name('employees.check');

Route::post('timelog/login', 'TimeLog\TimeLogController@login')->name('timelog.login');
Route::post('timelog/logoff', 'TimeLog\TimeLogController@logoff')->name('timelog.logoff');
