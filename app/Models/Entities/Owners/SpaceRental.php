<?php

namespace App\Models\Entities\Owners;

use Illuminate\Database\Eloquent\Model;
use App\Models\Entities\Traits\ModelTraits;
use App\Models\Entities\Users\Review;
use App\User as UserEntity;

class SpaceRental extends Model
{
    use ModelTraits;

    protected $table = 'owners_space_rentals';

    protected $guarded = [];

    protected $appends = [
        'category_csv',
        'category_decoded',
    	'full_address',
    	'rate_text',
    	'selected_days_text_short',
    	'requirements_decoded',
        'number_of_available_spaces',
        'full_class_name',
   	];

    public function owner()
    {
        return $this->hasOne(UserEntity::class, 'id', 'owner_id');
    }

    public function applications()
    {
    	return $this->hasMany(SpaceRentalApplication::class, 'space_rental_id', 'id');
    }

    public function review()
    {
        return $this->hasOne(Review::class, 'record_id', 'id')->where('record_type', self::class);
    }

    public function getCategoryDecodedAttribute()
    {
        if(empty($this->attributes['category'])){
            return json_decode('[]');
        }
        return json_decode($this->attributes['category']);
    }

    public function getCategoryCsvAttribute()
    {
        return join($this->category_decoded, ',');
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
    
    public function getRequirementsDecodedAttribute()
    {
        $requirements = $this->attributes['requirements'];
        if(is_null($requirements)){
            $requirements = '[]';
        }
    	return json_decode($requirements);
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

    public function getNumberOfAvailableSpacesAttribute()
    {
        return $this->attributes['number_of_spaces'] - $this->attributes['number_of_occupied_spaces'];
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

    public function setCategoryAttribute($value)
    {
        $this->attributes['category'] = json_encode($value);
    }

    public function setSelectedDaysAttribute($value)
    {
        $this->attributes['selected_days'] = json_encode($value);
    }

    public function setRequirementsAttribute($value)
    {
        $this->attributes['requirements'] = json_encode($value);
    }

    public function setRateAttribute($value)
    {
        $this->attributes['rate'] = (string)$value;
    }
}
