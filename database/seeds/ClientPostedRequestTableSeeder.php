<?php

use Illuminate\Database\Seeder;
use App\Models\Entities\Clients\PostedRequests;
use App\Models\Entities\Clients\PostedRequestApplications;

class ClientPostedRequestTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(
        	PostedRequests::class,
        	100
        )
        ->create()
        ->each(function($posted_request)
        {
            $count = rand(5, 10);
        	$posted_request
        		->prosApplications()
        		->saveMany(
        			factory(
        				PostedRequestApplications::class, 
        				$count
        			)->make()
        		);

            $posted_request->professionals_applied_count = $count;
            $posted_request->save();
        });
    }
}
