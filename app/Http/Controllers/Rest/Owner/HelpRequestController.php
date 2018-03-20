<?php

namespace App\Http\Controllers\Rest\Owner;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Entities\Owners\HelpRequest as HelpRequestEntity; 

class HelpRequestController extends Controller
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
        Request $request
    )
    {
        $help_requests = $this->help_request_entity;
        if($owner_id = $request->owner_id){
            $help_requests = $help_requests->ownedBy($owner_id, 'owner_id');
        }

        $help_requests = $help_requests->with('owner')->orderBy('id', 'DESC');
        
        $per_page = config('settings.pagination.per_page');

        if($request->recent_only){
            $help_requests = $help_requests->limit(5);
            $per_page = 5;
        }

        if($request->input('filters')){
            if($professional_types = $request->input('filters.professional_types')){
                $help_requests = $help_requests->where('category', 'LIKE', '%'.$professional_types.'%');
            }
        }

        return $help_requests->paginate($per_page);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(
        $owner_id,
        Request $request
    )
    {

        $posted_help_request = $request->input('posted_help_request');
        $posted_help_request['owner_id'] = $owner_id;

        if(($id = $posted_help_request['id']) > 0){
            $help_request_entity = $this
                                    ->help_request_entity
                                    ->updateOrCreate(
                                        ['id' => $id],
                                        $posted_help_request
                                    );
        }else{
            $help_request_entity = $this
                                    ->help_request_entity
                                    ->create(
                                        $posted_help_request
                                    );
        }
        
        return response()->json([
            'posted_help_request' => $help_request_entity,
            'success' => isset($help_request_entity->id)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(
        Request $request
    )
    {
        $help_request_entity = $this->help_request_entity;
        if($owner_id = $request->owner_id){
            $help_request_entity = $help_request_entity->ownedBy($owner_id, 'owner_id');
        }

        return $help_request_entity->with('owner')->find($request->help_request_id);
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
        Request $request
    )
    {
        $help_request_entity = $this
                                ->help_request_entity
                                ->ownedBy($owner_id, 'owner_id')
                                ->find($help_request_id);
        return response()->json([
            'success' => $help_request_entity->update($request->all())
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
