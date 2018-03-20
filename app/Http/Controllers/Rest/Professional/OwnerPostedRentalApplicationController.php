<?php

namespace App\Http\Controllers\Rest\Professional;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Entities\Professionals\ClientPostedRentalApplication as ClientPostedRentalApplicationEntity;

class OwnerPostedRentalApplicationController extends Controller
{
    protected $owner_posted_rental_application;

    public function __construct(ClientPostedRentalApplicationEntity $owner_posted_rental_application)
    {
        $this->owner_posted_rental_application = $owner_posted_rental_application;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($pro_id, Request $request)
    {
        $this->owner_posted_rental_application = ClientPostedRentalApplicationEntity::ownedBy($pro_id, 'professional_id')
                    ->with('postedRental');
                    
        $per_page = config('settings.pagination.per_page');
        if(isset($request->recent_only)){
            $this->owner_posted_rental_application = $this->owner_posted_rental_application->limit(5);
            $per_page = 5;
        }
        return $this
                ->owner_posted_rental_application
                ->orderBy('created_at', 'DESC')
                ->paginate($per_page);
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
        $application = new ClientPostedRentalApplicationEntity;
        $application = $application->create($request->input('application'));
        return response()->json([
            'success' => isset($application->id),
            'application' => $application,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($pro_id, $id,Request $request)
    {
        return ClientPostedRentalApplicationEntity::ownedBy($pro_id, 'professional_id')
                    ->with('postedRental')
                    ->findOrFail($id);
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
    public function update($pro_id, $id,Request $request)
    {
        $application = ClientPostedRentalApplicationEntity::find($id);
        return [
            'success' => $application->update($request->input('application')),
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($pro_id, $posted_request_id)
    {
        return response()->json([
            'success' => ClientPostedRentalApplicationEntity::ownedBy($pro_id, 'professional_id')->find($posted_request_id)->delete()
        ]);
    }

    public function getProApplication($pro_id, $posted_request_id, Request $request)
    {
        return [
            'application' => ClientPostedRentalApplicationEntity::ownedBy($pro_id, 'professional_id')->where('posted_request_id', $posted_request_id)->first()
        ];
    }
}
