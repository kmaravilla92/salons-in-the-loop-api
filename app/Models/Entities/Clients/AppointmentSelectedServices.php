<?php

namespace App\Models\Entities\Clients;

use Illuminate\Database\Eloquent\Model;
use App\Models\Entities\Traits\ModelTraits;
use App\Models\Entities\Professionals\Services as ProServicesEntity;

class AppointmentSelectedServices extends Model
{
	use ModelTraits;
	
    protected $table = 'client_appointment_selected_services';

    protected $guarded = [];

    public function proService()
    {
    	return $this->hasOne(ProServicesEntity::class, 'id', 'professional_service_id');
    }
}
