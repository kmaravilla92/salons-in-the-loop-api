<?php

namespace App\Http\Controllers\Rest\Professional;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Entities\Professionals\ClientPostedRequestApplication as ClientPostedRequestApplicationEntity;

class ClientPostedRequestApplicationController extends Controller
{
    protected $client_posted_request_application_entity;

    public function __construct(ClientPostedRequestApplicationEntity $client_posted_request_application_entity)
    {
        $this->client_posted_request_application_entity = $client_posted_request_application_entity;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($pro_id, Request $request)
    {
        $this->client_posted_request_application_entity = ClientPostedRequestApplicationEntity::ownedBy($pro_id, 'professional_id')
                    ->with(['postedRequest', 'postedRequest.client', 'professional']);
        $per_page = config('settings.pagination.per_page');
        if(isset($request->recent_only)){
            $this->client_posted_request_application_entity = $this->client_posted_request_application_entity->limit(5);
            $per_page = 5;
        }
        return $this
                ->client_posted_request_application_entity
                ->orderBy('created_at', 'DESC')
                ->paginate(
                    $per_page
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
        $application = new ClientPostedRequestApplicationEntity;
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
        return ClientPostedRequestApplicationEntity::ownedBy($pro_id, 'professional_id')
                    ->with(['postedRequest', 'postedRequest.client', 'professional'])
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
    public function update(Request $request, $id)
    {
        //
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
            'success' => ClientPostedRequestApplicationEntity::ownedBy($pro_id, 'professional_id')->find($posted_request_id)->delete()
        ]);
    }

    public function getProApplication($pro_id, $posted_request_id, Request $request)
    {
        return [
            'application' => ClientPostedRequestApplicationEntity::ownedBy($pro_id, 'professional_id')->where('posted_request_id', $posted_request_id)->first()
        ];
    }
}
