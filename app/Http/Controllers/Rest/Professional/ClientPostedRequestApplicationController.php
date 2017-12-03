<?php

namespace App\Http\Controllers\Rest\Professional;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Entities\Professionals\ClientPostedRequestApplication as ClientPostedRequestApplicationEntity;

class ClientPostedRequestApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($pro_id, Request $request)
    {
        return ClientPostedRequestApplicationEntity::ownedBy($pro_id, 'professional_id')
                    ->with('postedRequest')
                    ->orderBy('created_at', 'DESC')
                    ->get();
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
                    ->with('postedRequest')
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
