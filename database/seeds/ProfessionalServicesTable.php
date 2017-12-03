<?php

use Illuminate\Database\Seeder;
use App\Models\Entities\Professionals\Services as ProServicesEntity;

class ProfessionalServicesTable extends Seeder
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
            $pro
                ->proServices()
                ->saveMany(
                    factory(
                        ProServicesEntity::class,
                        10
                    )->make()
                );
        }
    }
}
