<?php

namespace App\Services;

use Paypalpayment;

class Payment {

	public function pay($type = 'paypal_checkeout', $payment_details = [])
	{
		$payment = null;
		switch($type){
			case 'paypal_checkeout':
				$payment = $this->paypalCheckout($payment_details);
			break;
			case 'paypal_credit_card':
				$payment = $this->paypalCreditCard($payment_details);
			break;
		}
		return $payment;
	}

	protected function paypalCheckout($payment_details = [])
	{
		// ### Payer
	    // A resource representing a Payer that funds a payment
	    // Use the List of `FundingInstrument` and the Payment Method
	    // as 'credit_card'
	    $payer = Paypalpayment::payer();
	    $payer->setPaymentMethod("paypal");

	    $items = [];

	    $item1 = Paypalpayment::item();
	    $item1->setName($payment_details['title'])
	            ->setDescription($payment_details['description'])
	            ->setCurrency('USD')
	            ->setQuantity(1)
	            ->setTax(0)
	            ->setPrice($payment_details['amount']);

	    $items[] = $item1;

	    $itemList = Paypalpayment::itemList();
	    $itemList->setItems($items);

	    $details = Paypalpayment::details();
	    $details->setShipping("0")
	            ->setTax("0")
	            //total of items prices
	            ->setSubtotal($payment_details['amount']);

	    //Payment Amount
	    $amount = Paypalpayment::amount();
	    $amount->setCurrency("USD")
	            // the total is $17.8 = (16 + 0.6) * 1 ( of quantity) + 1.2 ( of Shipping).
	            ->setTotal($payment_details['amount'])
	            ->setDetails($details);

	    // ### Transaction
	    // A transaction defines the contract of a
	    // payment - what is the payment for and who
	    // is fulfilling it. Transaction is created with
	    // a `Payee` and `Amount` types

	    $transaction = Paypalpayment::transaction();
	    $transaction->setAmount($amount)
	        ->setItemList($itemList)
	        ->setDescription($payment_details['description'])
	        ->setInvoiceNumber(uniqid());

	    // ### Payment
	    // A Payment Resource; create one using
	    // the above types and intent as 'sale'

	    $redirectUrls = Paypalpayment::redirectUrls();
	    $redirectUrls->setReturnUrl(str_replace('api.','',url($payment_details['success_url'])))
	        ->setCancelUrl(str_replace('api.','',url($payment_details['fail_url'])));

	    $payment = Paypalpayment::payment();

	    $payment->setIntent("sale")
	        ->setPayer($payer)
	        ->setRedirectUrls($redirectUrls)
	        ->setTransactions([$transaction]);

	    try {
	        // ### Create Payment
	        // Create a payment by posting to the APIService
	        // using a valid ApiContext
	        // The return object contains the status;
	        $payment->create(Paypalpayment::apiContext());
	    } catch (\PPConnectionException $ex) {
	        return response()->json(["error" => $ex->getMessage()], 400);
	    }
	    return response()->json(['success'=>true, 'payment'=>$payment->toArray(),'approval_url' => $payment->getApprovalLink()], 200);
	}

	protected function paypalCreditCard($payment_details = [])
	{
		// ### CreditCard
		$card = Paypalpayment::creditCard();
		$card->setType($payment_details['cc_type'])
		    ->setNumber($payment_details['cc_number'])
		    ->setExpireMonth($payment_details['cc_exp_month'])
		    ->setExpireYear($payment_details['cc_exp_year'])
		    ->setCvv2($payment_details['cc_exp_security'])
		    ->setFirstName($payment_details['cc_first_name'])
		    ->setLastName($payment_details['cc_last_name']);

		// ### FundingInstrument
		// A resource representing a Payer's funding instrument.
		// Use a Payer ID (A unique identifier of the payer generated
		// and provided by the facilitator. This is required when
		// creating or using a tokenized funding instrument)
		// and the `CreditCardDetails`
		$fi = Paypalpayment::fundingInstrument();
		$fi->setCreditCard($card);

		// ### Payer
		// A resource representing a Payer that funds a payment
		// Use the List of `FundingInstrument` and the Payment Method
		// as 'credit_card'
		$payer = Paypalpayment::payer();
		$payer->setPaymentMethod("credit_card")
		    ->setFundingInstruments([$fi]);

		$items = [];

		$item = Paypalpayment::item();
		$item->setName($payment_details['title'])
		        ->setDescription($payment_details['description'])
		        ->setCurrency('USD')
		        ->setQuantity(1)
		        ->setTax(0)
		        ->setPrice($payment_details['amount']);

		$items[] = $item;


		$itemList = Paypalpayment::itemList();
		$itemList->setItems($items);

		$details = Paypalpayment::details();
		$details->setShipping("0")
		        ->setTax("0")
		        //total of items prices
		        ->setSubtotal($payment_details['amount']);

		//Payment Amount
		$amount = Paypalpayment::amount();
		$amount->setCurrency("USD")
		        // the total is $17.8 = (16 + 0.6) * 1 ( of quantity) + 1.2 ( of Shipping).
		        ->setTotal($payment_details['amount'])
		        ->setDetails($details);

		// ### Transaction
		// A transaction defines the contract of a
		// payment - what is the payment for and who
		// is fulfilling it. Transaction is created with
		// a `Payee` and `Amount` types

		$transaction = Paypalpayment::transaction();
		$transaction->setAmount($amount)
		    ->setItemList($itemList)
		    ->setDescription($payment_details['description'])
		    ->setInvoiceNumber(uniqid());

		// ### Payment
		// A Payment Resource; create one using
		// the above types and intent as 'sale'

		$payment = Paypalpayment::payment();

		$payment->setIntent("sale")
		    ->setPayer($payer)
		    ->setTransactions([$transaction]);

		try {
		    // ### Create Payment
		    // Create a payment by posting to the APIService
		    // using a valid ApiContext
		    // The return object contains the status;
		    $payment->create(Paypalpayment::apiContext());
		} catch (\PPConnectionException $ex) {
		    return response()->json(["error" => $ex->getMessage()], 400);
		}

		return response()->json(['success'=>true, 'payment'=>$payment->toArray()], 200);
	}
}