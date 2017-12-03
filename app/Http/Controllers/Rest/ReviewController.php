<?php

namespace App\Http\Controllers\Rest;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Entities\Users\Review as ReviewEntity;

class ReviewController extends Controller
{

	public function index(Request $request)
	{
        
	}

    public function store(Request $request)
    {

        $response = [
            'success' => false,
            'messages' => []
        ];

    	$review_data = $request->only([
            'review.feedback',
    		'review.quality_of_service',
    		'review.professionalism',
    		'review.value',
    		'review.recommended',
    		'review.by_user_id',
    		'review.for_user_id',
    		'review._reserved_id_'
    	]);

        $review_data['review']['overall_rating'] = collect($review_data['review'])->only(['quality_of_service','professionalism','value'])->avg();

    	$review = new ReviewEntity;
        $review = $review->create($review_data['review']);
    	if($response['success'] = (isset($review->id))){
            $response['messages'][] = 'Review successfully posted.';
        }

        return response()->json($response);
    }

    public function show(Request $request)
    {

    }
}
