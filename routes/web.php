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


Route::get('/cadmin', 'HomeController@index')->name('home');
Route::get('/', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/getLoginOtp', [
	   'uses'   =>  'ApismsController@getLoginOtp',
	   'as'     =>  'getLoginOtp'
	]);
	Route::post('/getRegiterOtp', [
	   'uses'   =>  'ApismsController@getRegiterOtp',
	   'as'     =>  'getRegiterOtp'
	]);
	Route::post('/checkLogin', [
	   'uses'   =>  'ApismsController@checkLogin',
	   'as'     =>  'checkLogin'
	]);
	Route::post('/verifyOtp', [
	   'uses'   =>  'ApismsController@verifyOtp',
	   'as'     =>  'verifyOtp'
	]);
	Route::post('/otp', [
	   'uses'   =>  'ApismsController@otp',
	   'as'     =>  'otp'
	]);
	
	Route::post('/checkRegister', [
	   'uses'   =>  'ApismsController@checkRegister',
	   'as'     =>  'checkRegister'
	]);
Route::get('/associcate-register', 'DashobardController@associcateregister')->name('associcateregister');

Auth::routes();

Route::get('/cadmin', 'HomeController@index')->name('home');
Route::get('/home', 'DashobardController@index')->name('index');
Route::get('/dashboard', 'DashobardController@dashboard')->name('dashboard');
Route::post('/upload', 'DashobardController@upload')->name('upload');
Route::post('getAttandance', 'AccountantController@getAttandance');
Route::get('downloadReport/{slug}', 'ClientController@downloadReport');
Route::get('user/verify/{slug}', 'HomeController@verifyEmail');
Route::get('/myprofile', 'ProfileController@myprofile')->name('myprofile');
Route::post('/updateinfo ', 'ProfileController@updateinfo')->name('updateinfo');
Route::post('/updateaddressinfo ', 'ProfileController@updateaddressinfo')->name('updateaddressinfo');
Route::post('/updateaboutus ', 'ProfileController@updateaboutus')->name('updateaboutus');
Route::post('/updateserviceinfo ', 'ProfileController@updateserviceinfo')->name('updateserviceinfo');
Route::post('/updatebusiness ', 'ProfileController@updatebusiness')->name('updatebusiness');


