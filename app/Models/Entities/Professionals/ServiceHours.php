<?php

namespace App\Models\Entities\Professionals;

use Illuminate\Database\Eloquent\Model;
use App\Models\Entities\Traits\ModelTraits;

class ServiceHours extends Model
{
	use ModelTraits;
	
    protected $table = 'professional_service_hours';

    protected $guarded = [];

    protected $appends = ['service_hours_decoded'];

    public function getServiceHoursDecodedAttribute()
    {
    	return json_decode($this->service_hours);
    }
}
