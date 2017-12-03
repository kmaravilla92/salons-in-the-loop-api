<?php

use Illuminate\Database\Seeder;
use App\Models\Entities\PaymentHistory as PaymentHistoryEntity;
use App\User as UserEntity;

class PaymentHistoryTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$users = UserEntity::all();
        $users->each(function($user)
        {
        	factory(
	        	PaymentHistoryEntity::class,
	        	10
	        )
	        ->create()
	        ->each(function($payment) use($user)
        	{
        		$payment->owner_id = $user->id;
        		$payment->save();
        	});
        });
    }
}
