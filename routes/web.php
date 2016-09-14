<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

// Dashboard
Route::get('/', 'DashboardController@index');
Route::get('/financial', 'FinancialOverviewController@index');
Route::get('/financial/year/{year}', 'FinancialOverviewController@yearOverview');
Route::get('/financial/quarter/{year}/{quarter}', 'FinancialOverviewController@quarterOverview');
Route::get('/financial/month/{year}/{month}', 'FinancialOverviewController@monthOverview');

// Authentication
Route::get('login', 'Auth\AuthController@showLoginForm');
Route::post('login', 'Auth\AuthController@login');
Route::get('login/gauthentication', 'Auth\AuthController@gAuthentication');
Route::post('login/gauthentication', 'Auth\AuthController@gAuthenticate');
Route::get('logout', 'Auth\AuthController@logout');
Route::get('lock', 'Auth\AuthController@lock');
Route::get('locked', 'Auth\AuthController@locked');
Route::post('unlock', 'Auth\AuthController@unlock');

// Project
Route::get('project', 'ProjectController@index');
Route::get('project/archived', 'ProjectController@archivedProjects');
Route::get('project/new', 'ProjectController@create');
Route::get('project/{project}', 'ProjectController@show');
Route::patch('project/{project}', 'ProjectController@update');
Route::get('project/{project}/edit', 'ProjectController@edit');
Route::get('project/{project}/toggleShareability', 'ProjectController@toggleShareability');
Route::post('project/', 'ProjectController@store');
Route::delete('project/{project}', 'ProjectController@destroy');
Route::post('project/{project}/archive', 'ProjectController@archive');

// Timesheet
Route::get('project/{project}/timesheet', 'TimesheetController@index');
Route::get('project/{id}/customer', 'TimesheetController@showForCustomer');
Route::post('timesheet/start/', 'TimesheetController@startTime');
Route::post('timesheet/end/{timesheet}', 'TimesheetController@endTime');
Route::post('timesheet/{project}', 'TimesheetController@store');

// Invoice
Route::get('invoice', 'InvoiceController@index');
Route::post('invoice', 'InvoiceController@store');
Route::get('invoice/create', 'InvoiceController@create');
Route::get('invoice/all', 'InvoiceController@all');
Route::get('invoice/{invoice}', 'InvoiceController@show');
Route::patch('invoice/{invoice}', 'InvoiceController@update');
Route::delete('invoice/{invoice}', 'InvoiceController@destroy');
Route::get('invoice/{invoice}/pdf', 'InvoiceController@generatePDF');
Route::post('invoice/{invoice}/paid', 'InvoiceController@paid');
Route::get('invoice/{invoice}/edit', 'InvoiceController@edit');

Route::get('invoice/incoming/create', 'IncomingInvoiceController@create');
Route::post('invoice/incoming', 'IncomingInvoiceController@store');

// Customer
Route::get('customer', 'CustomerController@index');
Route::post('customer', 'CustomerController@store');
Route::get('customer/new', 'CustomerController@create');
Route::get('customer/{customer}', 'CustomerController@show');
Route::get('customer/{customer}/edit', 'CustomerController@edit');
Route::get('customer/{customer}/json', 'CustomerController@getCustomerJSON');
Route::patch('customer/{customer}', 'CustomerController@update');
Route::delete('customer/{customer}', 'CustomerController@destroy');

// Settings
Route::get('settings', 'SettingsController@index');
Route::get('settings/company', 'SettingsController@company');
Route::post('settings/company', 'SettingsController@companyUpdate');
Route::get('settings/account', 'SettingsController@account');
Route::post('settings/account', 'SettingsController@accountUpdate');
Route::get('settings/account/2fa', 'SettingsController@toggleTwoFactorAuthentication');
Route::get('settings/vat', 'SettingsController@vat');
Route::post('settings/vat', 'SettingsController@vatStore');
Route::delete('settings/vat/{id}', 'SettingsController@vatDestroy');

// Setup application for the first time
Route::get('setup', 'SetupController@index');
Route::post('setup', 'SetupController@store');
