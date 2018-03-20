<?php

namespace App\Models\Entities\Clients;

use Illuminate\Database\Eloquent\Model;
use App\Models\Entities\Traits\ModelTraits;
use App\User as UserEntity;
use App\Models\Entities\Clients\AppointmentSelectedServices as AppointmentSelectedServicesEntity;
use App\Models\Entities\Clients\AppointmentSelectedDateTime as AppointmentSelectedDateTimeEntity;
use App\Models\Entities\Users\Review;

class Appointments extends Model
{
	use ModelTraits;
	
    protected $table = 'client_appointments';

    protected $guarded = [];

    protected $appends = [
        'limited_selected_services',
        'limited_selected_time',
        'full_class_name',
    ];

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

    public function review()
    {
        return $this->hasOne(Review::class, 'record_id', 'id')->where('record_type', self::class);
    }

    public function getLimitedSelectedServicesAttribute()
    {
        return array_slice($this->selectedServices->toArray(), 0, 2);;
    }

    public function getLimitedSelectedTimeAttribute()
    {
        return array_slice($this->selectedDatetime->toArray(), 0, 2);
    }

    public function getCreatedAtAttribute()
    {
        return date('F d, Y', strtotime($this->attributes['created_at']));
    }
}
