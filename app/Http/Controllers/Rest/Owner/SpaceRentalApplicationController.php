<?php

namespace App\Http\Controllers\Rest\Owner;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Entities\Owners\SpaceRental as SpaceRentalEntity; 

class SpaceRentalApplicationController extends Controller
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
        $owner_id,
        $space_rental_id,
        Request $request
    )
    {
        $space_rental_entity = $this->space_rental_entity->ownedBy($owner_id, 'owner_id')->where('id',$space_rental_id)->first();
        
        if($space_rental_entity){
            return $space_rental_entity
                    ->applications()
                    ->with('professional')
                    ->orderBy('created_at', 'DESC')
                    ->paginate(
                        config('settings.pagination.per_page')
                    );
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
    public function store(
        $owner_id,
        $space_rental_id,
        Request $request
    )
    {
        
        $space_rental_entity = $this->space_rental_entity->ownedBy($owner_id, 'owner_id')->findOrFail($space_rental_id);
        $application = $space_rental_entity->applications()->create($request->input('rental_booking'));
        return response()->json([
            'success' => isset($application->id),
            'application' => $application
        ]);
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
        $space_rental_id,
        $application_id,
        Request $request
    )
    {
        // dd([$owner_id, $space_rental_id, $application_id]);
        $space_rental_entity = $this->space_rental_entity->ownedBy($owner_id, 'owner_id')->find($space_rental_id);

        $application = null;
        if($space_rental_entity){
            $application = $space_rental_entity->applications->find($application_id);
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
