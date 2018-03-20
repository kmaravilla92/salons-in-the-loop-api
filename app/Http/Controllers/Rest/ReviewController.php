<?php

namespace App\Http\Controllers\Rest;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Controllers\Controller;
use App\Models\Entities\Users\Review as ReviewEntity;
use App\Models\Entities\Clients\PostedRequests as ClientPostedRequestsEntity;
use App\Models\Entities\Clients\Appointments as ClientAppointmentsEntity;
use App\Models\Entities\Image as ImageEntity;
use App\Models\Entities\Owners\HelpRequest as OwnerHelpRequestEntity;
use App\Models\Entities\Owners\SpaceRental as OwnerSpaceRentalEntity;

class ReviewController extends Controller
{
    
	public function index(Request $request)
	{
        $user_type = $request->input('user_type', null);
        $user_id = $request->user_id;
        $to_review = [];
        $relatives = [
            ClientPostedRequestsEntity::class => ['review', 'hiredApplication.professional'],
            ClientAppointmentsEntity::class => ['review','professional'],
            OwnerHelpRequestEntity::class => ['review', 'hiredApplication.professional'],
            OwnerSpaceRentalEntity::class => ['review']
        ];
        switch($user_type) {
            case 'client':
                $client_requests = ClientPostedRequestsEntity::with($relatives[ClientPostedRequestsEntity::class])->ownedBy($user_id, 'user_id')->where('status', '3')->orderBy('created_at', 'DESC')->get()->toArray();
                $client_appointments = ClientAppointmentsEntity::with($relatives[ClientAppointmentsEntity::class])->ownedBy($user_id, 'client_id')->where('status', '5')->orderBy('created_at', 'DESC')->get()->map(function($client_appointment){
                        $client_appointment->title = 'Booked Appointment';
                        return $client_appointment;
                    })->toArray();
                $to_review = array_merge($client_requests, $client_appointments);
            break;
            case 'owner':
                $owner_help_requests = OwnerHelpRequestEntity::with($relatives[OwnerHelpRequestEntity::class])->ownedBy($user_id, 'owner_id')->where('status', '4')->orderBy('created_at', 'DESC')->get()->toArray();
                $owner_space_rentals = OwnerSpaceRentalEntity::with($relatives[OwnerSpaceRentalEntity::class])->ownedBy($user_id, 'owner_id')->orderBy('created_at', 'DESC')->get()->toArray();
                $to_review = array_merge($owner_help_requests, $owner_space_rentals);
            break;
            case 'professional':
                $reviews = ReviewEntity::where('for_user_id', $user_id)->orderBy('created_at', 'DESC')->get();
                foreach($reviews as $review) {
                    $to_review[] = $review->record_type::with($relatives[$review->record_type])->where('id', $review->record_id)->first()->toArray();
                }
            break;
            default:
            break;
        }
        // dd($to_review);
        $limit = 10;
        $start_page = $request->input('page', 0) * $limit;
        $to_review_count = count($to_review);
        $to_review_items = array_slice($to_review, $start_page, $limit);
        return new LengthAwarePaginator($to_review, count($to_review), 1);
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
    		'review.record_type',
            'review.record_id',
    	]);

    	$review = new ReviewEntity;
        $review = $review->create($review_data['review']);

        $photo_types = [
            'review_current_look_photos' => $request->input('review.current_look_photos')
        ];

        $photos_to_save = [];
        $photos_to_delete = [];
        
        $review->images()->where('type', 'review_current_look_photos')->delete();

        foreach($photo_types as $photo_type => $photos){
            if(count($photos)){
                foreach($photos as $photo){
                    $photos_to_save[] = new ImageEntity([
                        'name'      => $photo['name'],
                        'type'      => 'review_current_look_photos',
                        'type_id'   => $photo['type_id'],
                        'path'      => $photo['path'],
                        'status'    => '1'
                    ]);
                }
            }
        }

        if(count($photos_to_save)){
            $review->images()->saveMany($photos_to_save);
        }

    	if($response['success'] = (isset($review->id))){
            $response['messages'][] = 'Review successfully posted.';
        }

        return response()->json($response);
    }

    public function show(Request $request)
    {

    }
}
