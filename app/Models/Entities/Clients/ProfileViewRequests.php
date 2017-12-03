<?php

namespace App\Models\Entities\Clients;

use Illuminate\Database\Eloquent\Model;
use App\Models\Entities\Traits\ModelTraits;
use App\User as UserEntity;

class ProfileViewRequests extends Model
{
	use ModelTraits;
	
    protected $table = 'client_profile_view_requests';

    protected $guarded = [];

    public function client()
    {
    	return $this->hasOne(UserEntity::class, 'id', 'client_id');
    }

    public function viewer()
    {
    	return $this->hasOne(UserEntity::class, 'id', 'viewer_id');
    }
}
