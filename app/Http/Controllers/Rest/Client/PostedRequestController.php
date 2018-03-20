<?php

namespace App\Http\Controllers\Rest\Client;

use App\Models\Entities\Clients\PostedRequests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostedRequestController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user_id = $request->user_id;

        if($user_id){
            $posted_requests = PostedRequests::ownedBy($user_id);
        }else{
            $posted_requests = new PostedRequests;
        }
        $per_page = config('settings.pagination.per_page');
        if(isset($request->recent_only)){
            $posted_requests = $posted_requests->limit(5);
            $per_page = 5;
        }

        $posted_requests = $posted_requests->with('owner')->orderBy('created_at', 'DESC');
        
        if($request->input('filters')){
            if($professional_types = $request->input('filters.professional_types')){
                $posted_requests = $posted_requests->where('professional_types', 'LIKE', '%'.$professional_types.'%');
            }
        }
        
        return $posted_requests
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
    public function store($user_id, Request $request)
    {
        
        $inputs = $request->only([
            'name_my_own_price.professional_types',
            'name_my_own_price.title',
            'name_my_own_price.message',
            'name_my_own_price.desired_date',
            'name_my_own_price.desired_time',
            'name_my_own_price.servicing_area',
            'name_my_own_price.city',
            'name_my_own_price.state',
            'name_my_own_price.budget',
            'name_my_own_price.service_options',
            'name_my_own_price.current_look_photos',
            'name_my_own_price.desired_look_photos',
        ]);

        $details = $inputs['name_my_own_price'];
        $details['user_id'] = $user_id;
        $details['status'] = '0';
        $posted_request = PostedRequests::create($details);

        return response()->json([
            'success' => isset($posted_request->id),
            'posted_request' => $posted_request
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Entities\Clients\PostedRequests  $postedRequests
     * @return \Illuminate\Http\Response
     */
    public function show($user_id = null, $posted_request_id = null, Request $request)
    {

        $user_id = $request->user_id;

        if($request->posted_request_id){
            $posted_request_id = $request->posted_request_id;
        }

        $with = ['owner'];

        $posted_request = PostedRequests::with($with);

        if($user_id){
            $posted_request = $posted_request->ownedBy($user_id);
        }

        return $posted_request
                    ->where('id', $posted_request_id)
                    ->first();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Entities\Clients\PostedRequests  $postedRequests
     * @return \Illuminate\Http\Response
     */
    public function edit(PostedRequests $postedRequests)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Entities\Clients\PostedRequests  $postedRequests
     * @return \Illuminate\Http\Response
     */
    public function update($user_id = null, $posted_request_id = null, Request $request)
    {
        $user_id = $request->user_id;

        if($request->posted_request_id){
            $posted_request_id = $request->posted_request_id;
        }
        
        $posted_request = new PostedRequests;

        if($user_id){
            $posted_request = $posted_request->ownedBy($user_id);
        }

        $posted_request = $posted_request
                            ->where('id', $posted_request_id)
                            ->first();

        return response()->json([
            'success' => $posted_request->update($request->all())
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Entities\Clients\PostedRequests  $postedRequests
     * @return \Illuminate\Http\Response
     */
    public function destroy(PostedRequests $postedRequests)
    {
        //
    }
}
