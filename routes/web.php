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
    return view('welcome');
});

Route::get('/passport', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('firebase-test', function(\App\Services\FirebaseClient $firebase){

	// dd('No kidz here !!!');

	$firebase = $firebase->create();

	$professionals = \App\User::where('email', 'like', '%+pro%')->get();    
	$fb_professionals = [];

	foreach($professionals as $professional){
		$fb_professionals['professional-' . $professional->id] = [
			'id' => $professional->id,
			'profile_pic' => '',
			'full_name' => $professional->full_name,
			'address' => 'SAmple address',
			'rating' => rand(1, 5),
			'is_online' => [true,false][rand(0,1)]
		];
	}

	$database = $firebase->getDatabase();
	$ref = $database
			->getReference('/professionals')
			->set($fb_professionals);
});
