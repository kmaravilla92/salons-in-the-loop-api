<?php

namespace App\Models\Entities\Clients;

use Illuminate\Database\Eloquent\Model;
use App\Models\Entities\Traits\ModelTraits;
use App\User as UserEntity;

class PostedRequestApplications extends Model
{
	use ModelTraits;
	
    protected $table = 'client_posted_request_applications';

    protected $guarded = [];

    public function professional()
    {
    	return $this->hasOne(UserEntity::class, 'id', 'professional_id');
    }
}
