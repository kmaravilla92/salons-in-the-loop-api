<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User as UserEntity;
use App\Models\Entities\Users\PaymentInfo as PaymentInfoEntity;


class PaymentInfoController extends Controller
{

	protected $_user_id = null;

	public function __construct(Request $request)
	{
		$this->_user_id = $request->input('user_id');
		$user = UserEntity::where('id', $this->_user_id)->first();
	}

	protected function _getPaymentInfo()
	{
		return new PaymentInfoEntity;
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

		$response['success'] = $payment_info_entity->updateOrCreate(['user_id' => $this->_user_id], $payment_info);

		return response()->json($response);
	}
}