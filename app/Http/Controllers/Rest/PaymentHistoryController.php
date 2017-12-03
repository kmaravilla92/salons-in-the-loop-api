<?php

namespace App\Http\Controllers\Rest;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Entities\PaymentHistory as PaymentHistoryEntity;

class PaymentHistoryController extends Controller
{

	public function index($user_id = null, PaymentHistoryEntity $payment_history, Request $request)
	{
        $response = [
            'success' => true,
            'messages' => []
        ];

        if(isset($user_id)){
            $payment_history = $payment_history->ownedBy($user_id, 'owner_id');
        }

        $response['data'] = $payment_history->get();

        return response()->json($response);
	}

    public function store(Request $request)
    {

    }

    public function show(Request $request)
    {

    }

    public function update(Request $request, $id)
    {
        $response = [
            'success' => true,
            'messages' => []
        ];

        $payment = PaymentHistoryEntity::where('id', $id)->first();

        $response['success'] = $payment->update($request->all());

        if($response['success']){
            $response['messages'][] = 'Success';
        }

        return response()->json($response);
    }
}
