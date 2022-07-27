<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group(['prefix' => 'v1'], function() {
	Route::post('/checkLogin', [
	   'uses'   =>  'ApismsController@checkLogin',
	   'as'     =>  'checkLogin'
	]);
	Route::post('login', 'AuthController@login');
	Route::get('qetQualification', 'AuthController@qetQualification');
	Route::post('vgetRegiterOtp', 'ApismsController@vgetRegiterOtp');
	Route::post('vverifyRegiterOtp', 'ApismsController@vverifyRegiterOtp');
	Route::post('vgetLoginOtp', 'ApismsController@vgetLoginOtp');
	Route::post('vverifyLoginOtp', 'ApismsController@vverifyLoginOtp');
	Route::post('vresendOtp', 'ApismsController@vresendOtp');

	

	Route::post('register', 'AuthController@register');
	Route::post('getmobileRegiterOtp', 'AuthController@getmobileRegiterOtp');
	Route::post('getmobileLoginOtp', 'ApismsController@getmobileLoginOtp');
	Route::post('updateUserinfo', 'AuthController@updateUserinfo');
	Route::get('getState', 'AuthController@getState');
	Route::get('getVideocategory', 'CommonController@getVideocategory');
	Route::get('getBlog', 'CommonController@getBlog');
	Route::get('getVideotutorials', 'CommonController@getVideotutorials');
	Route::get('getAttandance', 'AccountantController@getAttandance');
	Route::get('getParentpackage', 'PackageController@getParentpackage');
	Route::get('getSubpackage', 'PackageController@getSubpackage');
	Route::get('packageDetails', 'PackageController@packageDetails');
	Route::get('getQuestion', 'QuestionsController@getQuestion');
	Route::get('getClientmenu', 'CommonController@getClientmenu');
	Route::get('getAppslider', 'CommonController@getAppslider');
	Route::post('uploadDoc', 'ClientController@uploadDoc');
	Route::post('uploadDocxx', 'ClientController@uploadDocxx');
	Route::post('forgetPassword', 'Auth\ForgotPasswordController@sendResetLinkEmail');
	Route::get('updateuser', 'CommonController@updateuser');
	//Route::get('getRequireddoclist', 'CommonController@getRequireddoclist');
	Route::get('searchService', 'MynetworkController@searchService');
});

Route::group(['prefix' => 'v1','middleware' => ['jwt.auth']], function() {
	Route::post('logout', 'AuthController@logout');
	Route::get('getUser', 'AuthController@getUser');
	Route::get('getUserx', 'AuthController@getUserx');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('updateAvtar', 'AuthController@updateAvtar');
	Route::post('updateUserinfobytoken', 'AuthController@updateUserinfobytoken');
    Route::post('me', 'AuthController@me');
	Route::post('inAccountant', 'AccountantController@inAccountant');
	Route::post('outAccountant', 'AccountantController@outAccountant');
	Route::get('getAclientlist', 'AccountantController@getAclientlist');
	Route::get('getAttandancewithtoken', 'AccountantController@getAttandancewithtoken');
	Route::post('chnagePaswordwithtoken', 'AuthController@chnagePaswordwithtoken');
	Route::post('savequizanswer', 'QuestionsController@savequizanswer');
	Route::get('getQuizresult', 'QuestionsController@getQuizresult');
	Route::get('getQuestionset', 'QuestionsController@getQuestionset');
	
	Route::post('addTodo', 'ClientController@addTodo');
	Route::get('getTodo', 'ClientController@getTodo');
	Route::get('getListofclientaccountant', 'ClientController@getListofclientaccountant');
	Route::get('getUplodedDocument', 'ClientController@getUplodedDocument');
	//Route::get('getUplodedDocument', 'ClientController@getUplodedDocument');
	Route::get('getSummery', 'ClientController@getSummery');	
	Route::get('getBalancesheet', 'ClientController@getBalancesheet');	
	Route::get('getSchedulesreport', 'ClientController@getSchedulesreport');	
	Route::get('getProfitloss', 'ClientController@getProfitloss');	
	Route::get('getUserWallet', 'AuthController@getUserWallet');	
	Route::post('createOrder', 'PaymentgetwayController@createOrder');
	Route::post('paymentCallback', 'PaymentgetwayController@paymentCallback');
	Route::get('getMyorder', 'PaymentgetwayController@getMyorder');	
	Route::get('getMainchecksum', 'PaymentgetwayController@getMainchecksum');
	Route::post('uploadOrderdoc', 'PaymentgetwayController@uploadOrderdoc');
	Route::get('checkCoupon', 'PaymentgetwayController@checkCoupon');
	Route::get('removeCoupon', 'PaymentgetwayController@removeCoupon');
	Route::get('deleteuploadOrderdoc', 'PaymentgetwayController@deleteuploadOrderdoc');
	Route::get('getUploadedservicedoc', 'PaymentgetwayController@getUploadedservicedoc');
	Route::get('getRequireddoclist', 'CommonController@getRequireddoclist');
	Route::get('getUploadeddoclist', 'CommonController@getUploadeddoclist');
	Route::get('getclientaccountantattandance', 'AccountantController@getclientaccountantattandance');
	Route::get('updateOrderId', 'PaymentgetwayController@updateOrderId');
	Route::get('updatePaymentStatus', 'PaymentgetwayController@updatePaymentStatus');
	Route::get('getInvoice', 'PaymentgetwayController@getInvoice');	
	Route::get('getMynetwork', 'MynetworkController@getMynetwork');	
	Route::post('addPaymentmethod', 'MynetworkController@addPaymentmethod');	
	Route::get('getPaymentmethodlist', 'MynetworkController@getPaymentmethodlist');	
	Route::get('deletePaymentmethod', 'MynetworkController@deletePaymentmethod');	
	Route::post('redeemPoint', 'MynetworkController@redeemPoint');	
	Route::get('getUsereasymoney', 'MynetworkController@getUsereasymoney');	
	Route::get('getTransactionlog', 'MynetworkController@getTransactionlog');	
	Route::get('getMethodtype', 'MynetworkController@getMethodtype');
	Route::get('getAssociate', 'MynetworkController@getAssociate');
	
});

