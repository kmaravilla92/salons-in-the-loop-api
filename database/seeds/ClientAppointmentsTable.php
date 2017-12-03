<?php

use Illuminate\Database\Seeder;
use App\Models\Entities\Clients\Appointments;
use App\Models\Entities\Clients\AppointmentSelectedDateTime;
use App\Models\Entities\Professionals\Services as ProfessionalServices;
use App\Models\Entities\Clients\AppointmentSelectedServices;

class ClientAppointmentsTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        $clients = App\User::where('email','like','%+client@%')->get();
        
        foreach($clients as $client){
            factory(
                Appointments::class,
                5
            )
            ->create()
            ->each(function($appointment) use($faker, $client)
            {
                $services = ProfessionalServices::limit(rand(2,5))->get();
                $total_price = 0;
                $total_duration = 0;
                $services_to_save = [];
                foreach($services as $service){
                    AppointmentSelectedServices::create([
                        'client_appointment_id' => $appointment->id,
                        'professional_service_id' => $service->id,
                        'additional_notes' => $faker->realText(75)
                    ]);
                    $total_price += $service->price;
                    $total_duration += $service->duration;
                }

                $appointment->client_id = $client->id;
                $appointment->total_price = $total_price;
                $appointment->total_duration = $total_duration;
                $appointment->save();

                $appointment
                    ->selectedDatetime()
                    ->saveMany(
                        factory(
                            AppointmentSelectedDateTime::class,
                            count($services)
                        )
                        ->make()
                        ->each(function($selected_date_time) use($appointment)
                        {
                            $selected_date_time->client_appointment_id = $appointment->id;
                            $selected_date_time->save();
                        })  
                    );
            });
        }
    }
}
