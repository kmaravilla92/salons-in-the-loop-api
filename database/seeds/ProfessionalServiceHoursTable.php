<?php

use Illuminate\Database\Seeder;
use App\Models\Entities\Professionals\ServiceHours as ProServiceHoursEntity;

class ProfessionalServiceHoursTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pros = App\User::where('email','like','%+professional@%')->get();
        foreach($pros as $pro){
            factory(
                ProServiceHoursEntity::class,
                1
            )
            ->create()
            ->each(function($service_hours) use($pro)
            {
            	$service_hours->professional_id = $pro->id;
            	$service_hours->save();
            });
        }
    }
}
