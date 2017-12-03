<?php

namespace App\Http\Controllers\Guest;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\UserSiteInquiry;
use App\User;
use Notification;

class ContactUsController extends Controller
{
	public function postSendInquiry(Request $request)
	{
		$receivers = User::where('email', 'like', '%info@%' )->get();
		$inquiry_details = $request->only([
							'contact.first_name', 
							'contact.last_name', 
							'contact.email', 
							'contact.number', 
							'contact.message'
						]);

		foreach($receivers as $receiver){
			Notification::send($receiver, new UserSiteInquiry($inquiry_details));
		}

		return response()->json([
			'success' => true,
			'messages' => [
				'Inquiry successfully sent!'
			]
		]);
	}
}