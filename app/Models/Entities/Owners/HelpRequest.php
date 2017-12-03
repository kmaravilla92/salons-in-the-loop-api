<?php

namespace App\Models\Entities\Owners;

use Illuminate\Database\Eloquent\Model;
use App\Models\Entities\Traits\ModelTraits;

class HelpRequest extends Model
{
	use ModelTraits;

    protected $table = 'owners_help_requests';

    protected $guarded = [];

    protected $appends = [
    	'full_address',
    	'rate_text',
    	'selected_days_text_short',
    	'service_options_decoded',
    	'payment_released',
   	];

    public function applications()
    {
    	return $this->hasMany(HelpRequestApplication::class, 'help_request_id', 'id');
    }

    public function getFullAddressAttribute()
    {
        $address = $this->address . ($this->address ? ' ,' : '' ) . $this->city . ($this->city ? ' ,' : '' ) . $this->state;
    	return empty($address) ? 'N\A' : $address;
    }

    public function getRateTextAttribute()
    {
    	return [
    		'Hourly Accepted ( enter hourly price )',
    		'Selected Day(s) ( enter daily price )',
    		'Weekly only ( enter weekly price )',
    		'Monthly only ( enter monthly price )'
    	][$this->attributes['rate']];
    }

    public function getSelectedDaysTextShortAttribute()
    {
    	$decoded_selected_days = json_decode($this->attributes['selected_days'], true);
    	if(is_null($decoded_selected_days))
    		return 'N\A';
    	return collect($decoded_selected_days)->implode(' ');
    }

    public function getServiceOptionsDecodedAttribute()
    {
    	if(is_null($this->service_options)){
            $this->service_options = '[]';
        }
        return json_decode($this->service_options);
    }

    public function getPaymentReleasedAttribute()
    {
    	return false;
    }

    public function getCreatedAtAttribute()
    {
        return date('m/d/Y', strtotime($this->attributes['created_at']));
    }

    public function getStartDateAttribute()
    {
    	return date('m/d/Y', strtotime($this->attributes['start_date']));
    }

    public function getEndDateAttribute()
    {
    	return date('m/d/Y', strtotime($this->attributes['end_date']));
    }

    public function getStartTimeAttribute()
    {
    	return date('h:i:s A', strtotime($this->attributes['start_time']));
    }

    public function getEndTimeAttribute()
    {
    	return date('h:i:s A', strtotime($this->attributes['end_time']));
    }

    public function setStartDateAttribute($value)
    {
    	$this->attributes['start_date'] = date('Y-m-d', strtotime($value));
    }

    public function setEndDateAttribute($value)
    {
    	$this->attributes['end_date'] = date('Y-m-d', strtotime($value));
    }

    public function setStartTimeAttribute($value)
    {
    	$this->attributes['start_time'] = date('H:i:s', strtotime($value));
    }

    public function setEndTimeAttribute($value)
    {
    	$this->attributes['end_time'] = date('H:i:s', strtotime($value));
    }

    public function setSelectedDaysAttribute($value)
    {
    	$this->attributes['selected_days'] = json_encode($value);
    }

    public function setServiceOptionsAttribute($value)
    {
    	$this->attributes['service_options'] = json_encode($value);
    }
}
