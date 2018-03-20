<?php

namespace App\Http\Controllers\Rest\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Entities\Clients\PostedRequestApplications as PostedRequestApplicationsEntity;

class PostedRequestApplicationController extends Controller
{
    public function index( 
        Request $request
    )
    {
        $professional_id = $request->pro_id;
        $posted_request_id = $request->posted_request_id;
        if($professional_id){
            $applications = PostedRequestApplicationsEntity::ownedBy($owner_id, 'professional_id');
        }else{
            $applications = new PostedRequestApplicationsEntity;
        }
        return $applications
                    ->with(['professional', 'professional.proProfile'])
                    ->where('posted_request_id', $posted_request_id)
                    ->paginate(
                        config('settings.pagination.per_page')
                    );
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
