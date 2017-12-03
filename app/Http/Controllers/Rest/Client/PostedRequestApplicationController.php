<?php

namespace App\Http\Controllers\Rest\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Entities\Clients\PostedRequestApplications as PostedRequestApplicationsEntity;

class PostedRequestApplicationController extends Controller
{
    public function index( 
        $posted_request_id, 
        Request $request
    )
    {
        $user_id = $request->user_id;
        if($user_id){
            $applications = PostedRequestApplicationsEntity::ownedBy($user_id);
        }else{
            $applications = new PostedRequestApplicationsEntity;
        }
        $applications = $applications
                            ->with('professional')
                            ->where('posted_request_id', $posted_request_id)
                            ->get();
        return response()->json($applications);
    }

    public function store(
        Request $request
    )
    {

    }

    public function update(
        $user_id, 
        $posted_request_id, 
        PostedRequestApplicationsEntity $application, 
        Request $request
    )
    {
        return response()->json([
            'success' => $application->update($request->all())
        ]);
    }
}
