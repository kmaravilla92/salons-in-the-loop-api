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
            $pros = App\User::where('email','like','%+professional@%')->get();
            foreach($pros as $pro){
                factory(
                     PostedRequestApplications::class, 
                     1
                 )
                ->create()
                ->each(function($application) use($posted_request, $pro)
                {
                    $application->posted_request_id = $posted_request->id;
                    $application->professional_id = $pro->id;
                    $application->save();
                });
            }

            $posted_request->professionals_applied_count = count($pros);
            $posted_request->save();
        });
    }
}
