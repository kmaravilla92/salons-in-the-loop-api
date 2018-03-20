<?php

namespace App\Http\Controllers\Rest\Client;

use App\Models\Entities\Clients\ProfileViewRequests as ProfileViewRequestsEntity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileViewRequestController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($user_id, Request $request)
    {
        return ProfileViewRequestsEntity::with(['client', 'viewer'])->where('client_id', $user_id)->orderBy('id', 'DESC')->paginate(config('settings.pagination.per_page'));
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
        $user_id, 
        ProfileViewRequestsEntity $profile_view_requests, 
        Request $request
    )
    {
        $profile_view_request = $profile_view_requests->firstOrCreate($request->all());
        return response()->json([
            'profile_view_request' => $profile_view_request,
            'success' => isset($profile_view_request->id)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Entities\Clients\ProfileViewRequests  $profile_view_requests
     * @return \Illuminate\Http\Response
     */
    public function show($user_id = null, $appoinment_id = null, Request $request)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Entities\Clients\ProfileViewRequests  $profile_view_requests
     * @return \Illuminate\Http\Response
     */
    public function edit(ProfileViewRequestsEntity $profile_view_requests)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Entities\Clients\ProfileViewRequests  $profile_view_requests
     * @return \Illuminate\Http\Response
     */
    public function update(
        $user_id, 
        $profile_view_request_id,
        Request $request
    )
    {   
        $profile_view_requests = ProfileViewRequestsEntity::find($profile_view_request_id);
        return response()->json([
            'success' => $profile_view_requests->update($request->all())
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Entities\Clients\ProfileViewRequests  $profile_view_requests
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        $user_id, 
        $profile_request_view_id, 
        ProfileViewRequestsEntity $profile_view_requests
    )
    {
        return $profile_view_requests->destroy($profile_request_view_id);
    }

    public function getCheck(
        $user_id, 
        $viewer_id,
        ProfileViewRequestsEntity $profile_view_requests, 
        Request $request
    )
    {
        return $profile_view_requests->where(function($query) use($user_id, $viewer_id)
            {
                $query
                    ->where('client_id', $user_id)
                    ->where('viewer_id', $viewer_id);
            })->orderBy('id', 'DESC')->first();
    }
}
