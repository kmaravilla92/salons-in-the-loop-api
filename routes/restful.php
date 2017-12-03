<?php

Route::get('info', function(){
	return config('app.api');
});
Route::resource('users', 'UserController');
Route::resource('users/{user_id}/posted-requests', 'Client\PostedRequestController');
Route::resource('users/{user_id}/posted-requests/{posted_request_id}/applications', 'Client\PostedRequestApplicationController');
Route::resource('users/{user_id}/appointments', 'Client\AppointmentController');

Route::get('users/{user_id}/profile-view-requests/check/{viewer_id}', 'Client\ProfileViewRequestController@getCheck');
Route::resource('users/{user_id}/profile-view-requests', 'Client\ProfileViewRequestController');

Route::resource('users/{user_id}/services', 'Professional\ServiceController');
Route::resource('users/{user_id}/service-hours', 'Professional\ServiceHoursController');
Route::resource('users/{user_id}/payment-history', 'PaymentHistoryController');
Route::resource('users/{user_id}/waiting-list', 'Professional\WaitingListController');

// OWNERS
Route::resource('owners/{owner_id}/help-requests', 'Owner\HelpRequestController');
Route::resource('owners/{owner_id}/help-requests/{help_request_id}/applications', 'Owner\HelpRequestApplicationController');
Route::resource('owners/{owner_id}/space-rentals', 'Owner\SpaceRentalController');
Route::resource('owners/{owner_id}/space-rentals/{space_rental_id}/applications', 'Owner\HelpRequestApplicationController');

// PROS
Route::group([
	'prefix'=>'professionals/{pro_id}',
	'namespace'=>'Professional'
], function() {
	Route::resource('client/posted-requests/applications', 'ClientPostedRequestApplicationController');
	Route::get('client/posted-requests/{posted_request_id}/applications', 'ClientPostedRequestApplicationController@getProApplication');
});

Route::resource('reviews', 'ReviewController');
Route::resource('payment-history', 'PaymentHistoryController');
Route::resource('blog-posts', 'BlogPostController');
Route::get('posted-requests', 'Client\PostedRequestController@index');
Route::get('posted-requests/{posted_request_id}', 'Client\PostedRequestController@show');
Route::get('posted-requests/{posted_request_id}/applications', 'Client\PostedRequestApplicationController@index');

Route::get('posted-rentals', 'Owner\SpaceRentalController@index');
Route::get('posted-rentals/{posted_rental_id}', 'Owner\SpaceRentalController@show');

Route::resource('images', 'ImageController');