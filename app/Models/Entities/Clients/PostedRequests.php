<?php

namespace App\Models\Entities\Clients;

use Illuminate\Database\Eloquent\Model;
use App\Models\Entities\Traits\ModelTraits;

class PostedRequests extends Model
{
	use ModelTraits;
	
    protected $table = 'client_posted_requests';

    protected $guarded = [];

    protected $appends = [
        'full_address',
    ];

    public function prosApplications()
    {
    	return $this->hasMany(PostedRequestApplications::class, 'posted_request_id', 'id');
    }

    public function owner()
    {
    	return $this->hasOne(\App\User::class, 'id', 'user_id');
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
}
