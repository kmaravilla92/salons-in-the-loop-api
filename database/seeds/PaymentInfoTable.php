<?php

use Illuminate\Database\Seeder;
use App\Models\Entities\Users\PaymentInfo as PaymentInfoEntity;
use App\User as UserEntity;

class PaymentInfoTable extends Seeder
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
	        	PaymentInfoEntity::class,
	        	1
	        )
	        ->create()
	        ->each(function($payment) use($user)
        	{
                $payment->cc_name = $user->full_name;
        		$payment->user_id = $user->id;
        		$payment->save();
        	});
        });
    }
}
