<?php

namespace App\Models\Entities\Clients;

use Illuminate\Database\Eloquent\Model;
use App\Models\Entities\Traits\ModelTraits;
use App\User as UserEntity;
use App\Models\Entities\Clients\AppointmentSelectedServices as AppointmentSelectedServicesEntity;
use App\Models\Entities\Clients\AppointmentSelectedDateTime as AppointmentSelectedDateTimeEntity;

class Appointments extends Model
{
	use ModelTraits;
	
    protected $table = 'client_appointments';

    protected $guarded = [];

    public function client()
    {
    	return $this->hasOne(UserEntity::class, 'id', 'client_id');
    }

    public function professional()
    {
    	return $this->hasOne(UserEntity::class, 'id', 'professional_id');
    }

    public function selectedServices()
    {
    	return $this->hasMany(AppointmentSelectedServicesEntity::class, 'client_appointment_id', 'id');
    }

    public function selectedDatetime()
    {
        return $this->hasMany(AppointmentSelectedDateTimeEntity::class, 'client_appointment_id', 'id');
    }
}
