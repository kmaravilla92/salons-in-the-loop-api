<?php

namespace App\Http\Controllers\Rest\Professional;

use App\Models\Entities\Professionals\Services;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Entities\Professionals\ServiceHours as ServiceHoursEntity;

class ServiceHoursController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(
        $user_id, 
        ServiceHoursEntity $service_hours_entity, 
        Request $request
    )
    {
        // 
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Entities\Clients\Services  $services
     * @return \Illuminate\Http\Response
     */
    public function show(
        $user_id, 
        $service_hours_id,
        ServiceHoursEntity $service_hours_entity, 
        Request $request
    )
    {
        $service_hours = $service_hours_entity
                            ->where('professional_id', $user_id)
                            ->firstOrFail();        

        return $service_hours;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Entities\Clients\Services  $services
     * @return \Illuminate\Http\Response
     */
    public function edit(Services $services)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Entities\Clients\Services  $services
     * @return \Illuminate\Http\Response
     */
    public function update(
        $user_id, 
        $service_hours_id,
        ServiceHoursEntity $service_hours_entity, 
        Request $request
    )
    {
        $service_hours_entity = $service_hours_entity
                                    ->where('professional_id', $user_id)
                                    ->firstOrFail();
        $service_hour = $request->input('service_hour');
        $service_hour['service_hours'] = json_encode($service_hour['service_hours_decoded']);
        unset($service_hour['service_hours_decoded']);
        return response()->json([
            'success' => $service_hours_entity->update($service_hour)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Entities\Clients\Services  $services
     * @return \Illuminate\Http\Response
     */
    public function destroy(Services $services)
    {
        //
    }
}
