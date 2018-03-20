<?php

namespace App\Http\Controllers\Rest\Professional;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Entities\Clients\Appointments as AppointmentEntity;

class ClientAppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return AppointmentEntity::with([
                    'client',
                    'selectedServices',
                    'selectedServices.proService',
                    'selectedDatetime'
                ])
                ->where('professional_id', $request->pro_id)
                ->paginate(
                    config('settings.pagination.per_page')
                );
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($user_id = null, $appoinment_id = null, Request $request)
    {
        $user_id = $request->user_id;

        if($request->posted_request_id){
            $appoinment_id = $request->posted_request_id;
        }

        $with = [
            'client',
            'selectedServices',
            'selectedServices.proService',
            'selectedDatetime'
        ];

        $appoinment = AppointmentEntity::with($with);

        if($user_id){
            $appoinment = $appoinment->ownedBy($user_id, 'professional_id');
        }

        $appoinment = $appoinment
                            ->where('id', $appoinment_id)
                            ->first();
        
        return $appoinment;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($user_id = null, $appoinment_id = null, Request $request)
    {
        $appoinment = AppointmentEntity::find($appoinment_id);
        return [
            'success' => $appoinment->update($request->input('appointment'))
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
