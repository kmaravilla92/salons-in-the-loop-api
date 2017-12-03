<?php

use Illuminate\Database\Seeder;
use App\Models\Entities\Clients\ProfileViewRequests as ProfileViewRequestsEntity;

class ClientProfileViewRequestsTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $clients = App\User::where('email','like','%+client@%')->get();

        foreach($clients as $client){

        	$pros = App\User::where('email','like','%+professional@%')->get();

        	foreach($pros as $pro){

        		ProfileViewRequestsEntity::create([
	        		'client_id' => $client->id,
	        		'viewer_id' => $pro->id,
	        		'status' => '0'
	        	]);

        	}
        }
    }
}
