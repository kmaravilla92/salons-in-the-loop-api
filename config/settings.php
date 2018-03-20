<?php

return [
	'professional_types' => [
		'Barber',
		'Hair Stylist',
		'Esthetician',
		'Manicurist/Pedicurist',
		'Braider',
		'Weavers',
		'Shampoo Techs',
		'Salon Assistant',
		'Lash/Brow Specialist',
		'Colorist',
		'Cosmetology Student',
		'Mobile Stylist',
		'Travelling Stylist',
		'Makeup Artist',
		'Boutique Representative',
		'Health and Beauty Professional',
		'Other'
	],
	'professionals' => [
		'default_service_hours' => json_encode([
            'Sunday' => ['start_time'=>'9:00 AM', 'end_time'=>'5:00 PM', 'is_open'=>'no'],
            'Monday' => ['start_time'=>'9:00 AM', 'end_time'=>'5:00 PM', 'is_open'=>'no'],
            'Tuesday' => ['start_time'=>'9:00 AM', 'end_time'=>'5:00 PM', 'is_open'=>'no'],
            'Wednesday' => ['start_time'=>'9:00 AM', 'end_time'=>'5:00 PM', 'is_open'=>'no'],
            'Thursday' => ['start_time'=>'9:00 AM', 'end_time'=>'5:00 PM', 'is_open'=>'no'],
            'Friday' => ['start_time'=>'9:00 AM', 'end_time'=>'5:00 PM', 'is_open'=>'no'],
            'Saturday' => ['start_time'=>'9:00 AM', 'end_time'=>'5:00 PM', 'is_open'=>'no'],
        ])
	],
	'owners' => [
		'category' => [
			'Hair Salon',
			'Barber Shop',
			'Nail Salon',
			'Pop Up Salon',
			'Wax Center',
			'Braiding Salon',
			'Hair Replacement Clinic',
			'Beauty Spa',
			'Tanning Salon',
			'Boutique',
			'Salon Suites',
			'Other'
		]
	],
	'pagination' => [
		'per_page' => 25
	],
	'reviews' => [
		'record_types' => [
			'client_posted_request' => 'App\Models\Entities\Clients\PostedRequests',
			'client_appointment' => 'App\Models\Entities\Clients\Appointments',
			'owner_help_request' => 'App\Models\Entities\Owners\HelpRequest' ,
			'owner_space_rental' => 'App\Models\Entities\Owners\SpaceRental',
		]
	],
	'service_options_labels' => [
    	'must_be_performed_in_a_salon' => 'Services must be performed in a Salon',
    	'pro_must_be_licensed' => 'Professional must be licensed',
    	'needed_at_address_below' => 'Services needed at address below',
    	'other_area' => 'Other Area'
    ]
];