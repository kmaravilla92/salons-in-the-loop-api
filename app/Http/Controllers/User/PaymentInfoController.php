<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User as UserEntity;


class PaymentInfoController extends Controller
{

	protected $_payment_info = null;

	public function __construct(Request $request)
	{
		$user = UserEntity::where('id', $request->input('user_id'))->first();
		$this->_payment_info = $user->paymentInfo;
	}

	protected function _getPaymentInfo()
	{
		return $this->_payment_info;
	}

	public function getPaymentInfo()
	{
	
		$payment_info = $this->_getPaymentInfo();

		return response()->json([
			'card_info' =>  [
				'cc_name' => $payment_info->cc_name,
				'cc_number' => $payment_info->cc_number,
				'cc_exp_month' => $payment_info->cc_exp_month,
				'cc_exp_year' => $payment_info->cc_exp_year,
				'cc_sec_code' => $payment_info->cc_sec_code,
				'cc_type' => $payment_info->cc_type,
			],
			'billing_address' => [
				'billing_address' => $payment_info->billing_address,
		        'billing_city' => $payment_info->billing_city,
		        'billing_postal' => $payment_info->billing_postal,
		        'billing_state' => $payment_info->billing_state,
		        'billing_country' => $payment_info->billing_country,
			]
		]);
	}

	public function updatePaymentInfo(Request $request)
	{
		$response = [
			'messages' => [],
			'success' => false
		];

		$payment_info_entity = $this->_getPaymentInfo();
		$payment_info = array_merge(
			$request->input('payment_info.card_info'), 
			$request->input('payment_info.billing_address')
		);

		$response['success'] = $payment_info_entity->update($payment_info);

		return response()->json($response);
	}
}