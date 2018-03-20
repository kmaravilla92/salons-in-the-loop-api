<?php

namespace App\Models\Entities\Professionals;

use Illuminate\Database\Eloquent\Model;
use App\Models\Entities\Traits\ModelTraits;

class Services extends Model
{
	use ModelTraits;
	
    protected $table = 'professional_services';

    protected $guarded = [];

    protected $appends = [];

    public function getStatusAttribute($value)
    {
    	return $this->attributes['status'] == '1'; // true o false
    }

    public function setStatusAttribute($value)
    {
    	$this->attributes['status'] = $value ? '1' : '0';
    }
}
