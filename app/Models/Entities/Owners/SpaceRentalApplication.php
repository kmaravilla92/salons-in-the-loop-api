<?php

namespace App\Models\Entities\Owners;

use Illuminate\Database\Eloquent\Model;
use App\User as UserEntity;

class SpaceRentalApplication extends Model
{
    protected $table = 'owners_space_rentals_applications';

    protected $guarded = [];

    public function professional()
    {
    	return $this->hasOne(UserEntity::class, 'id', 'professional_id');
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
}
