<?php

use App\Http\Controllers\Admin\EmployeeController;

/**
	*Admin Protected Routes Starts Here.
	*Only Admins Can Access.
	*Middleware:auth.
	*prefix:admin.
	*/
Route::group(['middleware' =>['auth'], 'prefix' =>'admin'],function(){

	Route::get('/dashboard',[EmployeeController::class,'dashboard'])->name('dashboard');

	Route::resource('employee',EmployeeController::class);
	Route::get('employee-data',[EmployeeController::class,'getdata'])->name('employee_data');
});