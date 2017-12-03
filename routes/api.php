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

Route::get('info', function (Faker\Generator $faker) {
	return config('app.api');
});

Route::any('contact-us', 'Guest\ContactUsController@postSendInquiry');

Route::get('user/account-settings', 'User\AccountSettingsController@getSettings');
Route::post('user/change-email', 'User\AccountSettingsController@postChangeEmail');
Route::post('user/change-password', 'User\AccountSettingsController@postChangePassword');

Route::get('user/payment-info', 'User\PaymentInfoController@getPaymentInfo');
Route::put('user/payment-info', 'User\PaymentInfoController@updatePaymentInfo');

Route::get('search/pros', function() {
	$pros_groups = \Sentinel::findRoleByName('Professionals');
	$pros_ids = $pros_groups->users()->pluck('id');
	return \App\User::whereIn('id', $pros_ids)->get()->keyBy('id');
});

Route::get('set-presence/{user_id}/{presence}', function($user_id, $presence, \App\Services\FirebaseClient $firebase){
	$sentinel_user = \Sentinel::findUserById($user_id);
	if($sentinel_user->hasAccess('professional')){
		$firebase = $firebase->create();
		$database = $firebase->getDatabase();
		$ref = $database
				->getReference('/professionals/professional-' . $user_id .'/is_online')
				->set($presence);
	}
});


