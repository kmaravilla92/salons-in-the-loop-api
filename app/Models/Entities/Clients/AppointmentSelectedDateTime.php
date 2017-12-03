<?php

namespace App\Models\Entities\Clients;

use Illuminate\Database\Eloquent\Model;
use App\Models\Entities\Traits\ModelTraits;

class AppointmentSelectedDateTime extends Model
{
	use ModelTraits;
	
    protected $table = 'client_appointment_selected_date_time';

    protected $guarded = [];
}
