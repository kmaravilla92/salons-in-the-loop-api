<?php

namespace App\Services;

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

class FirebaseClient {

	public function create()
	{
		$serviceAccount = ServiceAccount::fromJsonFile(storage_path('sitl-6e7a3-firebase-adminsdk-mf2p4-6566891031.json'));
		$apiKey = 'AIzaSyA1pfyOEoSgnb3833rIGQBii3o7knKZJH4';
		$firebase = (new Factory)
		    ->withServiceAccountAndApiKey($serviceAccount, $apiKey)
		    ->create();

		return $firebase;
	}
}