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
        // dd($request->input('filters'));
        $space_rentals = $this->space_rental_entity;

        if($owner_id = $request->owner_id){
            $space_rentals = $space_rentals->ownedBy($owner_id, 'owner_id');
        }

        $space_rentals = $this->_applyFilters($space_rentals, $request->input('filters'));

        $space_rentals = $space_rentals->with(['owner', 'owner.ownerProfile'])->orderBy('id', 'DESC');
        
        $per_page = config('settings.pagination.per_page');

        if($request->recent_only){
            $space_rentals = $space_rentals->limit(5);
            $per_page = 5;
        }

        return $space_rentals->paginate($per_page);
    }

    private function _applyFilters($space_rentals, $filters)
    {
        if(0 === count($filters)){
            return $space_rentals;
        }

        foreach($filters as $key => $filter){
            switch($key){
                case 'professional_type':
                    if(!empty($filters['professional_type'])){
                        $space_rentals = $space_rentals->where('category', 'LIKE', '%'.$filters['professional_type'].'%');
                    }
                break;
                case 'availability':
                    $availability = $filter;
                    if(!empty($availability['date']['from']) && !empty($availability['date']['to'])){
                        $space_rentals = $space_rentals->where(function($query) use($availability)
                        {
                            $from = date('Y-m-d', strtotime($availability['date']['from']));
                            $to = date('Y-m-d', strtotime($availability['date']['to']));
                            $query
                                ->whereDate('start_date', '>=', $from)
                                ->whereDate('end_date', '<=', $to);
                        });
                    }
                break;
                case 'days':
                    $days = $filter;
                    if(count($days) > 0){
                        $space_rentals = $space_rentals->where(function($query) use($days)
                        {
                            foreach($days as $day){
                                $query->orWhere('selected_days', 'LIKE', '%'.$day.'%');
                            }
                        });
                    }
                break;
            }
        }

        return $space_rentals;
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

        $space_rental = $request->input('space_rental');
        $space_rental['owner_id'] = $owner_id;

        if(($id = $space_rental['id']) > 0){
            $space_rental_entity = $this
                                    ->space_rental_entity
                                    ->updateOrCreate(
                                        ['id' => $id],
                                        $space_rental
                                    );
        }else{
            $space_rental_entity = $this
                                    ->space_rental_entity
                                    ->create(
                                        $space_rental
                                    );
        }
        
        return response()->json([
            'space_rental' => $space_rental_entity,
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
        Request $request
    )
    {
        if($owner_id = $request->owner_id){
            $this->space_rental_entity = $this->space_rental_entity->ownedBy($owner_id, 'owner_id');
        }
        
        $this->space_rental_entity = $this->space_rental_entity->with('owner')->find($request->posted_rental_id);

        if($this->space_rental_entity){
            $this->space_rental_entity->renters_count = $this->space_rental_entity->applications()->count();
            $this->space_rental_entity->save();
        }

        return $this->space_rental_entity;
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
