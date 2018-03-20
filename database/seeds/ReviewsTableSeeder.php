<?php

use Illuminate\Database\Seeder;
use App\Models\Entities\Users\Review;

class ReviewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$pros = App\User::where('email','like','%+professional@%')->get();
        foreach($pros as $pro) {
            factory(Review::class, 5)->create()->each(function($review) use($pro) 
            {
            	$review->for_user_id = $pro->id;
            	$review->save();
            });
        }
    }
}
