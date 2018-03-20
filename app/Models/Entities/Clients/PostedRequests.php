<?php

namespace App\Models\Entities\Clients;

use Illuminate\Database\Eloquent\Model;
use App\Models\Entities\Traits\ModelTraits;
use App\Models\Entities\Users\Review;
use App\User;

class PostedRequests extends Model
{
	use ModelTraits;
	
    protected $table = 'client_posted_requests';

    protected $guarded = [];

    protected $appends = [
        'professional_types_csv',
        'professional_types_decoded',
        'title_short',
        'message_short',
        'full_address',
        'service_options_decoded',
        'full_class_name',
        'category_csv'
    ];

    public function prosApplications()
    {
    	return $this->hasMany(PostedRequestApplications::class, 'posted_request_id', 'id');
    }

    public function hiredApplication()
    {
        return $this->hasOne(PostedRequestApplications::class, 'id', 'hired_application');
    }

    public function owner()
    {
    	return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function client()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function review()
    {
        return $this->hasOne(Review::class, 'record_id', 'id')->where('record_type', self::class);
    }

    public function getProfessionalTypesCsvAttribute()
    {
        return join($this->professional_types_decoded, ',');
    }

    public function getCategoryCsvAttribute()
    {
        return join($this->professional_types_decoded, ',');
    }

    public function getProfessionalTypesDecodedAttribute()
    {
        if(empty($this->attributes['professional_types'])){
            return json_decode('[]');
        }
        return json_decode($this->attributes['professional_types']);
    }

    public function getTitleShortAttribute()
    {
        return $this->truncate($this->attributes['title'], 50);
    }

    public function getMessageShortAttribute()
    {
        return $this->truncate($this->attributes['message'], 100);
    }

    public function getFullAddressAttribute()
    {
        $address = $this->servicing_area . ($this->servicing_area ? ' ,' : '' ) . $this->city . ($this->city ? ' ,' : '' ) . $this->state;
        return empty($address) ? 'N\A' : $address;
    }

    public function getCreatedAtAttribute()
    {
        return date('m/d/Y', strtotime($this->attributes['created_at']));
    }

    public function getDesiredDateAttribute()
    {
        return date('m/d/Y', strtotime($this->attributes['desired_date']));
    }

    public function getDesiredTimeAttribute()
    {
        return date('h:i:s A', strtotime($this->attributes['desired_time']));
    }

    public function getServiceOptionsDecodedAttribute()
    {
        if(is_null($this->attributes['service_options'])){
            $this->attributes['service_options'] = '[]';
        }
        $service_options = json_decode($this->attributes['service_options']);
        $service_options_arr = [];
        foreach($service_options as $key => $value){
            if($value == 1){
                $service_options_arr[] = config('settings.service_options_labels.' . $key); 
            }
            if($key == 'other_area'){
                $service_options_arr[] = $value;
            }
        }
        return $service_options_arr;
    }

    public function getCurrentLookPhotosAttribute()
    {
        if(is_null($this->attributes['current_look_photos'])){
            $this->attributes['current_look_photos'] = '[]';
        }
        return json_decode($this->attributes['current_look_photos']);
    }

    public function getDesiredLookPhotosAttribute()
    {
        if(is_null($this->attributes['desired_look_photos'])){
            $this->attributes['desired_look_photos'] = '[]';
        }
        return json_decode($this->attributes['desired_look_photos']);
    }

    public function setDesiredDateAttribute($value)
    {
        $this->attributes['desired_date'] = date('Y-m-d', strtotime($value));
    }

    public function setDesiredTimeAttribute($value)
    {
        $this->attributes['desired_time'] = date('H:i:s', strtotime($value));
    }

    public function setProfessionalTypesAttribute($value)
    {
        $this->attributes['professional_types'] = json_encode($value);
    }

    public function setCurrentLookPhotosAttribute($value)
    {
        $this->attributes['current_look_photos'] = json_encode($value);
    }

    public function setDesiredLookPhotosAttribute($value)
    {
        $this->attributes['desired_look_photos'] = json_encode($value);
    }

    public function setServiceOptionsAttribute($value)
    {
        $this->attributes['service_options'] = json_encode($value);
    }
}
