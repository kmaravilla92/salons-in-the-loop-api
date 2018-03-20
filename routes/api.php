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

Route::get('lang/{lang?}', function ($lang) {
	App::setLocale($lang);
	return [App::getLocale(), __('test.greet', ['name'=>'Kim'])];
});

Route::get('info', function (Faker\Generator $faker) {
	return config('app.api');
});

Route::any('contact-us', 'Guest\ContactUsController@postSendInquiry');

Route::get('user/account-settings', 'User\AccountSettingsController@getSettings');
Route::post('user/change-email', 'User\AccountSettingsController@postChangeEmail');
Route::post('user/change-password', 'User\AccountSettingsController@postChangePassword');

Route::get('user/payment-info', 'User\PaymentInfoController@getPaymentInfo');
Route::put('user/payment-info', 'User\PaymentInfoController@updatePaymentInfo');

Route::get('search/pros', function(Request $request) {
	$pros_groups = \Sentinel::findRoleByName('Professionals');
	$per_page = config('settings.pagination.per_page');
	$pros_ids = $pros_groups->users()->pluck('id');
	$professional_types = isset($request->filters['professional_type']) ? $request->filters['professional_type'] : [];
	$pro_name = $request->filters['pro_name'];
	$pro_phone_number = $request->filters['pro_phone_number'];
	
	$pros = \App\User::with(['proProfile', 'proProfile.ownerBlocking'])
		->whereIn('id', $pros_ids);

	if(!empty($pro_phone_number)){
		$pros = $pros->where('phone_number', 'LIKE', '%'.$pro_phone_number.'%');
	}	

	if(!empty($pro_name)){
		$full_name = $pro_name;
		$fuzzy_name = explode(' ', $pro_name);

		$pros = $pros->where(function ($query) use($pro_name, $fuzzy_name) {
			$query
				->where('first_name', 'LIKE', '%'.$pro_name.'%')
				->orWhere('last_name', 'LIKE', '%'.$pro_name.'%');

			foreach($fuzzy_name as $name) {
				$query
					->orWhere('first_name', 'LIKE', '%'.$name.'%')
					->orWhere('last_name', 'LIKE', '%'.$name.'%');
			}
		});
	}	

	$pros = $pros->paginate($per_page)->toArray();

	$pros['data'] = collect($pros['data'])->filter(function($pro) use($request, $professional_types)
		{
			if(empty($request->filters['professional_type'])){
				return true;
			}

			if(!isset($pro['pro_profile'])){
				return false;
			}
			
			foreach($professional_types as $professional_type){
				return in_array($professional_type, $pro['pro_profile']['category_decoded']);
			}
			return false;

		})
		->keyBy('id');

	return $pros;
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


