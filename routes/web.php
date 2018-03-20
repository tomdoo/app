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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', 'HomeController@index');
Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
Route::get('/account/informations', 'AccountController@informations')->name('account.informations');
Route::get('/account/subscriptions', 'AccountController@subscriptions')->name('account.subscriptions');
Route::get('/account/institutions', 'AccountController@institutions')->name('account.institutions');
Route::get('/institutions', 'InstitutionsController@index')->name('institutions');
Route::get('/events', 'EventsController@index')->name('events');
Route::get('/messenger', 'MessengerController@index')->name('messenger');
Route::get('/faq', 'FaqController@index')->name('faq');

Route::get('/auth/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('/auth/{provider}/callback', 'Auth\LoginController@handleProviderCallback');
