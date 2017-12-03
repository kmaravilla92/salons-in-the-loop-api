<?php

namespace App\Http\Controllers\Rest\Client;

use App\Models\Entities\Clients\Appointments as AppointmentsEntity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AppointmentController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user_id = $request->user_id;

        if($user_id){
            $appointments = AppointmentsEntity::ownedBy($user_id, 'client_id');
        }else{
            $appointments = new AppointmentsEntity;
        }

        $appointments = $appointments->with([
            'professional',
            'selectedServices',
            'selectedServices.proService',
            'selectedDatetime'
        ]);

        return $appointments
                ->orderBy('created_at', 'DESC')
                ->get()
                ->map(function($appointment)
                {
                    $appointment->limited_selected_services = array_slice($appointment->selectedServices->toArray(), 0, 2);

                    $appointment->limited_selected_time = array_slice($appointment->selectedDatetime->toArray(), 0, 2);
                    return $appointment;
                });
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($user_id, Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Entities\Clients\AppointmentsEntity  $appointments
     * @return \Illuminate\Http\Response
     */
    public function show($user_id = null, $appoinment_id = null, Request $request)
    {
        $user_id = $request->user_id;

        if($request->posted_request_id){
            $appoinment_id = $request->posted_request_id;
        }

        $with = [
            'professional',
            'selectedServices',
            'selectedServices.proService',
            'selectedDatetime'
        ];

        $appoinment = AppointmentsEntity::with($with);

        if($user_id){
            $appoinment = $appoinment->ownedBy($user_id, 'client_id');
        }

        $appoinment = $appoinment
                            ->where('id', $appoinment_id)
                            ->first();
        
        return $appoinment;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Entities\Clients\AppointmentsEntity  $appointments
     * @return \Illuminate\Http\Response
     */
    public function edit(AppointmentsEntity $appointments)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Entities\Clients\AppointmentsEntity  $appointments
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AppointmentsEntity $appointments)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Entities\Clients\AppointmentsEntity  $appointments
     * @return \Illuminate\Http\Response
     */
    public function destroy(AppointmentsEntity $appointments)
    {
        //
    }
}
