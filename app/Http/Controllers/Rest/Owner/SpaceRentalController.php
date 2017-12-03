<?php

namespace App\Http\Controllers\Rest\Owner;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Entities\Owners\SpaceRental as SpaceRentalEntity; 

class SpaceRentalController extends Controller
{

    public function __construct(
        SpaceRentalEntity $space_rental_entity
    )
    {
        $this->space_rental_entity = $space_rental_entity;
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
        if($owner_id = $request->owner_id){
            $this->space_rental_entity = $this->space_rental_entity->ownedBy($owner_id, 'owner_id');
        }

        $help_requests = $this->space_rental_entity->orderBy('id', 'DESC');
        
        if($request->recent_only){
            $help_requests = $help_requests->limit(5);
        }

        return $help_requests->get();
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
            $space_rental_entity = $this
                                    ->space_rental_entity
                                    ->updateOrCreate(
                                        ['id' => $id],
                                        $posted_help_request
                                    );
        }else{
            $space_rental_entity = $this
                                    ->space_rental_entity
                                    ->create(
                                        $posted_help_request
                                    );
        }
        
        return response()->json([
            'posted_help_request' => $space_rental_entity,
            'success' => isset($space_rental_entity->id)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(
        $posted_rental_id,
        Request $request
    )
    {
        if($owner_id = $request->owner_id){
            $this->space_rental_entity = $this->space_rental_entity->ownedBy($owner_id, 'owner_id');
        }
        return $this->space_rental_entity->find($posted_rental_id);
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
        $space_rental_entity = $this
                                ->space_rental_entity
                                ->ownedBy($owner_id, 'owner_id')
                                ->find($help_request_id);
        return response()->json([
            'success' => $space_rental_entity->update($request->all())
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
