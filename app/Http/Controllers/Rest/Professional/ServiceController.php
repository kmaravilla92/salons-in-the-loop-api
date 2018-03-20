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
        return Services::ownedBy($request->user_id, 'professional_id')->orderBy('created_at', 'DESC')->get();
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
        $existing_services = ServicesEntity::where('professional_id', $user_id);
        $existing_services->delete();

        if($services = $request->input('services')){
            foreach($services as $service){
                unset(
                    $service['deleted_at'],
                    $service['updated_at'],
                    $service['created_at']
                );
                $service_id = isset($service['id']) ? $service['id'] : null;
                ServicesEntity::updateOrCreate([
                    'id' => $service_id
                ], $service);
            }
        }

        return response()->json([
            'success' => true,
            'services' => $existing_services->orderBy('created_at', 'DESC')->get()
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
