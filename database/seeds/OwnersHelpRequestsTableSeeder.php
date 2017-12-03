<?php

use Illuminate\Database\Seeder;
use App\Models\Entities\Owners\HelpRequest as HelpRequestEntity;
use App\Models\Entities\Owners\HelpRequestApplication as HelpRequestApplicationEntity;

class OwnersHelpRequestsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $owners = App\User::where('email','like','%+owner@%')->get();
        foreach($owners as $owner) {
        	factory(
        		HelpRequestEntity::class,
        		10
        	)
        	->create()
        	->each(function($help_request) use($owner){

        		$help_request
        			->applications()
        			->saveMany(
        				factory(
        					HelpRequestApplicationEntity::class,
        					rand(5, 10)
        				)->make()
        			);

        		$help_request->owner_id = $owner->id;
        		$help_request->professionals_applied_count = $help_request->applications()->count();
        		$help_request->save();
        	});
        }
    }
}
