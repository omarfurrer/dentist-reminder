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
    $countries = \App\Helpers\Countries::$countries;
    $pricePlans = \App\PricePlan::all();
    return view('landing', compact('countries', 'pricePlans'));
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::post('sms/{sms}/status/update', 'SmsController@updateStatus');


Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', 'DashboardController@getDashboard')->name('dashboard');
    Route::post('/dashboard/appointments', 'DashboardController@addAppointmentWithPatient');
    Route::delete('/dashboard/appointments/{appointment}', 'DashboardController@deleteAppointment');
    Route::get('/billing', 'BillingController@getBilling');
    Route::get('/billing/approve', 'BillingController@approve');
});


