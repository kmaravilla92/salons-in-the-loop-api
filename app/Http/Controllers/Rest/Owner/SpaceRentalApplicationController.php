<?php

namespace App\Http\Controllers\Rest\Owner;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Entities\Owners\HelpRequest as HelpRequestEntity; 

class HelpRequestApplicationController extends Controller
{
    public function __construct(
        HelpRequestEntity $help_request_entity
    )
    {
        $this->help_request_entity = $help_request_entity;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(
        $owner_id,
        $help_request_id,
        Request $request
    )
    {
        $help_request_entity = $this->help_request_entity->ownedBy($owner_id, 'owner_id')->find($help_request_id);
        
        if($help_request_entity){
            return $help_request_entity->applications()->with('professional')->get();
        }
        return [];
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
        // return response()->json([
        // ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function update(
        $owner_id,
        $help_request_id,
        $application_id,
        Request $request
    )
    {
        // dd([$owner_id, $help_request_id, $application_id]);
        $help_request_entity = $this->help_request_entity->ownedBy($owner_id, 'owner_id')->find($help_request_id);

        $application = null;
        if($help_request_entity){
            $application = $help_request_entity->applications->find($application_id);
            if($application){
                return response()->json([
                    'success' => $application->update($request->all())
                ]);
            }
        }
        return response()->json([
            'success' => false
        ]);   
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
