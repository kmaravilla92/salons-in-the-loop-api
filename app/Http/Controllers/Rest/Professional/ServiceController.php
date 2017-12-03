<?php

namespace App\Http\Controllers\Rest\Professional;

use App\Models\Entities\Professionals\Services;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Entities\Professionals\Services as ServicesEntity;

class ServiceController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user_id = $request->user_id;

        $services = Services::ownedBy($user_id, 'professional_id')->orderBy('created_at', 'ASC')->get();

        return collect($services)->map(function($service)
            {
                $service['status'] = $service['status'] == '1' ? true : false;
                return $service;
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
        $existing_services = ServicesEntity::where('professional_id', $user_id)->delete();

        if($services = $request->input('services')){
            foreach($services as $service){
                unset(
                    $service['deleted_at'],
                    $service['updated_at'],
                    $service['created_at']
                );
                $service_id = isset($service['id']) ? $service['id'] : null;

                if(is_bool($service['status'])){
                    $service['status'] = $service['status'] ? '1' : '0';
                }
                
                if(!is_null($service_id)){
                    $service_entity = ServicesEntity::find($service_id);
                    if($service_entity){
                        unset($service['id']);
                        $service_entity->update($service);
                    }
                }else{
                    ServicesEntity::create($service);
                }
            }
        }

        return response()->json([
            'success' => true
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Entities\Clients\Services  $services
     * @return \Illuminate\Http\Response
     */
    public function show($user_id = null, $posted_request_id = null, Request $request)
    {

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
    public function update(Request $request, Services $services)
    {
        //
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
