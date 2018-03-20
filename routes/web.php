<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/passport', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('firebase-test', function(\App\Services\FirebaseClient $firebase){

	// dd('No kidz here !!!');

	$firebase = $firebase->create();

	$professionals = \App\User::where('email', 'like', '%+pro%')->get();    
	$fb_professionals = [];

	foreach($professionals as $professional){
		$fb_professionals['professional-' . $professional->id] = [
			'id' => $professional->id,
			'profile_pic' => '',
			'full_name' => $professional->full_name,
			'address' => 'SAmple address',
			'rating' => rand(1, 5),
			'is_online' => [true,false][rand(0,1)]
		];
	}

	$database = $firebase->getDatabase();
	$ref = $database
			->getReference('/professionals')
			->set($fb_professionals);
});

Route::get('payments/success', function(Illuminate\Http\Request $request){
	return $request->all();
});

Route::get('payments/fails', function(Illuminate\Http\Request $request){
	return $request->all();
});

Route::get('paypal-test', function(){

    // ### Payer
    // A resource representing a Payer that funds a payment
    // Use the List of `FundingInstrument` and the Payment Method
    // as 'credit_card'
    $payer = Paypalpayment::payer();
    $payer->setPaymentMethod("paypal");

    $item1 = Paypalpayment::item();
    $item1->setName('Ground Coffee 40 oz')
            ->setDescription('Ground Coffee 40 oz')
            ->setCurrency('USD')
            ->setQuantity(1)
            ->setTax(0.3)
            ->setPrice(7.50);

    $item2 = Paypalpayment::item();
    $item2->setName('Granola bars')
            ->setDescription('Granola Bars with Peanuts')
            ->setCurrency('USD')
            ->setQuantity(5)
            ->setTax(0.2)
            ->setPrice(2);


    $itemList = Paypalpayment::itemList();
    $itemList->setItems([$item1,$item2]);


    $details = Paypalpayment::details();
    $details->setShipping("1.2")
            ->setTax("1.3")
            //total of items prices
            ->setSubtotal("17.5");

    //Payment Amount
    $amount = Paypalpayment::amount();
    $amount->setCurrency("USD")
            // the total is $17.8 = (16 + 0.6) * 1 ( of quantity) + 1.2 ( of Shipping).
            ->setTotal("20")
            ->setDetails($details);

    // ### Transaction
    // A transaction defines the contract of a
    // payment - what is the payment for and who
    // is fulfilling it. Transaction is created with
    // a `Payee` and `Amount` types

    $transaction = Paypalpayment::transaction();
    $transaction->setAmount($amount)
        ->setItemList($itemList)
        ->setDescription("Payment description")
        ->setInvoiceNumber(uniqid());

    // ### Payment
    // A Payment Resource; create one using
    // the above types and intent as 'sale'

    $redirectUrls = Paypalpayment::redirectUrls();
    $redirectUrls->setReturnUrl(url("/payments/success"))
        ->setCancelUrl(url("/payments/fails"));

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

    return response()->json([$payment->toArray(), 'approval_url' => $payment->getApprovalLink()], 200);
});
