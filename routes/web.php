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

// account
Route::get('/account/informations', 'AccountController@informations')->name('account.informations');
Route::post('/account/informations', 'AccountController@informations')->name('account.informations');
Route::get('/account/subscriptions', 'AccountController@subscriptions')->name('account.subscriptions');

// clubs
Route::get('/clubs', 'ClubsController@index')->name('clubs');
Route::get('/clubs/view/{clubId}', 'ClubsController@view')->name('clubs.view');
Route::get('/clubs/create', 'ClubsController@create')->name('clubs.create');
Route::post('/clubs/create', 'ClubsController@create')->name('clubs.create');
Route::get('/clubs/edit/{clubId}', 'ClubsController@edit')->name('clubs.edit');
Route::post('/clubs/edit/{clubId}', 'ClubsController@edit')->name('clubs.edit');
Route::get('/clubs/delete/{clubId}', 'ClubsController@delete')->name('clubs.delete');
Route::get('/clubs/members/{clubId}', 'ClubsController@members')->name('clubs.members');
Route::get('/clubs/membersArchive/{clubId}', 'ClubsController@membersArchive')->name('clubs.membersArchive');
Route::get('/clubs/member/{clubId}/{userId}', 'ClubsController@member')->name('clubs.member');
Route::get('/clubs/anonymousMember/{clubId}/{anonymousUserId}', 'ClubsController@anonymousMember')->name('clubs.anonymousMember');
Route::get('/clubs/addMember', 'ClubsController@addMember')->name('clubs.addMember');
Route::post('/clubs/addMember', 'ClubsController@addMember')->name('clubs.addMember');
Route::get('/clubs/addAnonymousMember/{clubId}', 'ClubsController@addAnonymousMember')->name('clubs.addAnonymousMember');
Route::post('/clubs/addAnonymousMember/{clubId}', 'ClubsController@addAnonymousMember')->name('clubs.addAnonymousMember');
Route::post('/clubs/addPhoto/{clubId}', 'ClubsController@addPhoto')->name('clubs.addPhoto');
Route::get('/clubs/getPhoto/{clubPhotoId}', 'ClubsController@getPhoto')->name('clubs.getPhoto');
Route::get('/clubs/setPrimaryPhoto/{clubPhotoId}', 'ClubsController@setPrimaryPhoto')->name('clubs.setPrimaryPhoto');
Route::get('/clubs/deletePhoto/{clubPhotoId}', 'ClubsController@deletePhoto')->name('clubs.deletePhoto');
Route::post('/clubs/addAdministrator/{clubId}', 'ClubsController@addAdministrator')->name('clubs.addAdministrator');

// events
Route::get('/events', 'EventsController@index')->name('events');
Route::get('/events/view/{eventId}', 'EventsController@view')->name('events.view');
Route::get('/events/edit/{clubId?}', 'EventsController@edit')->name('events.edit');
Route::post('/events/edit/{clubId?}', 'EventsController@edit')->name('events.edit');
Route::get('/events/delete/{eventId}', 'EventsController@delete')->name('events.delete');
Route::get('/events/participate/{eventId}/{participate}', 'EventsController@participate')->name('events.participate');
Route::get('/events/subscribeAnonymous/{eventId}', 'EventsController@subscribeAnonymous')->name('events.subscribeAnonymous');
Route::post('/events/subscribeAnonymous/{eventId}', 'EventsController@subscribeAnonymous')->name('events.subscribeAnonymous');
Route::get('/events/unsubscribeAnonymous/{eventId}/{anonymousUserId}', 'EventsController@unsubscribeAnonymous')->name('events.unsubscribeAnonymous');

// notifications
Route::get('/notifications', 'NotificationsController@index')->name('notifications');

// faq
Route::get('/faq', 'FaqController@index')->name('faq');

// auth
Route::get('/auth/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('/auth/{provider}/callback', 'Auth\LoginController@handleProviderCallback');
