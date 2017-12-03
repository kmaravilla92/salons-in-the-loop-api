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
	]
];