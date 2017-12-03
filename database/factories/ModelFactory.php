<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$random_pro_id = function(){
	$pro = App\User::where('email','like','%+professional@%')->inRandomOrder()->first();
	return $pro->id;
};

$random_client_id = function(){
	$client = App\User::where('email','like','%+client@%')->inRandomOrder()->first();
	return $client->id;
};

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function(Faker\Generator $faker)
{

	$user_roles = ['professional','client','owner'];
	$user_role = $user_roles[rand(0, count($user_roles) - 1)];

	return [
		'email' => $faker->firstName . '+' . $user_role . '@' . $faker->domainName,
		'first_name' => $faker->firstName,
		'last_name' => $faker->lastName,
		'phone_number' => $faker->phoneNumber,
		'password' => 'password',
		'user_role' => $user_role
	];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Entities\BlogPost::class, function (Faker\Generator $faker) {

	$featured_images = [
		'/frontsite/images/blog1.jpg',
		'/frontsite/images/blog2.jpg',
		'/frontsite/images/blog3.jpg',
		'/frontsite/images/blog4.jpg'
	];

	$inner_images = [
		'/frontsite/images/blog-img.jpg',
		'/frontsite/images/blog-img2.jpg',
	];

	$contents = [
		'<p>' . $faker->realText(500) . '</p>',
		'<br><br>',
		'<img src="'.$inner_images[rand(0,1)].'">',
		'<br><br>',
		'<p>' . $faker->realText(500). '</p>',
		'<br><br>',
		'<img src="'.$featured_images[rand(1,2)].'">',
		'<br><br>',
		'<p>' . $faker->realText(500). '</p>',
		'<br><br>',
		'<img src="'.$inner_images[rand(0,1)].'">',
		'<br><br>',
		'<p>' . $faker->realText(500). '</p>',
		'<br><br>',
		'<img src="'.$featured_images[rand(0,2)].'">'
	];

    return [
        'slug' 				=> $faker->slug,
        'title' 			=> $faker->realText(150),
        'status' 			=> '1',
        'content' 			=> implode('', $contents),
        'excerpt' 			=> $faker->realText(150),
        'featured_image' 	=> $featured_images[rand(0,2)],
    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Entities\Clients\PostedRequests::class, function(Faker\Generator $faker)
{
	$professional_types = config('settings.professional_types');
	$user = App\User::where('email','like','%+client@%')->inRandomOrder()->first();
	$user_professional_types = [];
	foreach(range(0, rand(1,5)) as $i){
		$user_professional_types[] = $professional_types[rand(0, count($professional_types) - 1)];
	}
	return [
		'user_id' => $user->id,
		'professional_types'=>implode(',', $user_professional_types),
        'title'=>$faker->realText(150),
        'message'=>$faker->realText(150),
        'desired_date'=>date('Y-m-d'),
        'desired_time'=>date('H:i:s'),
        'servicing_area'=>$faker->streetAddress,
        'city'=>$faker->city,
        'state'=>$faker->state,
        'budget'=>$faker->randomFloat(2, 1000, 99999),
        'service_options'=>json_encode([
        	'must_be_performed_in_a_salon' => ['0','1'][rand(0,1)],
        	'pro_must_be_licensed' => ['0','1'][rand(0,1)],
        	'needed_at_address_below' => ['0','1'][rand(0,1)],
        	'other_area' => ''
        ]),
        'current_look_photos'=>'',
        'desired_look_photos'=>'',
	];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Entities\Clients\PostedRequestApplications::class, function(Faker\Generator $faker) use($random_pro_id)
{
	return [
		'professional_id' => $random_pro_id(),
		'proposal' => $faker->realText(150),
	];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Entities\Professionals\Services::class, function(Faker\Generator $faker) use($random_pro_id)
{
	return [
		'professional_id' => $random_pro_id(),
		'service_name' => ['Hair Cut', 'Hair Dry', 'Hair Trim', 'Hair Gel'][rand(0, 3)],
		'duration' => $faker->randomFloat(2, 30, 60),
		'price' => $faker->randomFloat(2, 1000, 9999)
	];
});	

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Entities\Professionals\ServiceHours::class, function(Faker\Generator $faker)
{
	return [
		'professional_id' => 1,
		'service_hours' => config('settings.professionals.default_service_hours'),
	];
});	

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Entities\Clients\Appointments::class, function(Faker\Generator $faker) use($random_pro_id, $random_client_id)
{
	return [
		// 'client_id' => $random_client_id,
		'professional_id' => $random_pro_id(),
		'total_price' => 0,
		'total_duration' => 0,
		'status' => '1'
	];
});	

$factory->define(App\Models\Entities\Clients\AppointmentSelectedDateTime::class, function(Faker\Generator $faker)
{
	return [
		'client_appointment_id' => 1,
		'booking_date_time' => date('Y-m-d H:i:s', time()),
		'location' => $faker->city . ',' . $faker->state,
	];
});	

$factory->define(App\Models\Entities\PaymentHistory::class, function(Faker\Generator $faker)
{
	return [
		'title' => $faker->realText(75),
		'description' => $faker->realText(75),
		'amount' => $faker->randomFloat(2, 1000, 9999),
		'status' => ['0', '1', '2'][rand(0, 2)],
		'owner_id' => 0
	];
});

$factory->define(App\Models\Entities\Users\PaymentInfo::class, function(Faker\Generator $faker)
{
	return [
		'cc_name' => '',
        'cc_number' => $faker->creditCardNumber,
        'cc_exp_month' => '0'.rand(1, 12),
        'cc_exp_year' => rand(2018, 2025),
        'cc_sec_code' => 123,
        'cc_type' => $faker->creditCardType,
        'billing_address' => $faker->streetAddress,
        'billing_city' => $faker->city,
        'billing_postal' => $faker->postcode,
        'billing_state' => $faker->state,
        'billing_country' => $faker->country,
        'user_id' => 0
	];
});

$factory->define(App\Models\Entities\Owners\HelpRequest::class, function(Faker\Generator $faker)
{
	return [
		'owner_id' => 0,	
		'category' => ['Barber', 'Hair Stylist', 'Esthetician'][rand(0, 2)],
		'title' => $faker->realText(75),
		'description' => $faker->realText(150),
		'rate' => ['0', '1', '2', '3'][rand(0, 3)],
		'weekly_total' => $faker->randomFloat(2, 1000, 9999),
		'selected_days' => json_encode(['Mon'=>'Monday', 'Tue'=>'Tuesday', 'Sun'=>'Sunday']),
		'start_date' => date('Y-m-d'),
		'end_date' => date('Y-m-d'),
		'start_time' => date('H:i:s'),
		'end_time' => date('H:i:s'),
		'address' => $faker->address,
		'city' => $faker->city,
		'state' => $faker->state,
		'service_options' => json_encode([]),
		'professionals_applied_count' => 0,
	];
});

$factory->define(App\Models\Entities\Owners\HelpRequestApplication::class, function(Faker\Generator $faker) use($random_pro_id)
{
	return [
		'professional_id' => $random_pro_id(),
		'help_request_id' => 0,
		'application_status' => '0',
		'status' => ['0', '1'][rand(0, 1)],
	];
});

$factory->define(App\Models\Entities\Owners\SpaceRental::class, function(Faker\Generator $faker)
{
	return [
		'owner_id' => 0,	
		'category' => ['Barber', 'Hair Stylist', 'Esthetician'][rand(0, 2)],
		'title' => $faker->realText(75),
		'description' => $faker->realText(150),
		'number_of_spaces' => rand(1,4),
		'rate' => ['0', '1', '2', '3'][rand(0, 3)],
		'rate_price' => $faker->randomFloat(2, 1000, 9999),
		'selected_days' => json_encode(['Mon'=>'Monday', 'Tue'=>'Tuesday', 'Sun'=>'Sunday']),
		'start_date' => date('Y-m-d'),
		'end_date' => date('Y-m-d'),
		'start_time' => date('H:i:s'),
		'end_time' => date('H:i:s'),
		'address' => $faker->address,
		'city' => $faker->city,
		'state' => $faker->state,
		'requirements' => json_encode([]),
		'renters_count' => 0,
	];
});

$factory->define(App\Models\Entities\Owners\SpaceRentalApplication::class, function(Faker\Generator $faker) use($random_pro_id)
{
	return [
		'professional_id' => $random_pro_id(),
		'space_rental_id' => 0,
		'application_status' => '0',
		'status' => ['0', '1'][rand(0, 1)],
	];
});