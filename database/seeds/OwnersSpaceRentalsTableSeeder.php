<?php

use Illuminate\Database\Seeder;
use App\Models\Entities\Owners\SpaceRental as SpaceRentalEntity;
use App\Models\Entities\Owners\SpaceRentalApplication as SpaceRentalApplicationEntity;

class OwnersSpaceRentalsTableSeeder extends Seeder
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
        		SpaceRentalEntity::class,
        		10
        	)
        	->create()
        	->each(function($help_request) use($owner){

        		$help_request
        			->applications()
        			->saveMany(
        				factory(
        					SpaceRentalApplicationEntity::class,
        					rand(5, 10)
        				)->make()
        			);

        		$help_request->owner_id = $owner->id;
        		$help_request->renters_count = $help_request->applications()->count();
        		$help_request->save();
        	});
        }
    }
}
