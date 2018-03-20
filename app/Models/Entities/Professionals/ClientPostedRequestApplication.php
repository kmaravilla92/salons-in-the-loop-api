<?php

namespace App\Models\Entities\Professionals;

use Illuminate\Database\Eloquent\Model;
use App\Models\Entities\Clients\PostedRequests as PostedRequestsEntity;
use App\Models\Entities\Traits\ModelTraits;
use App\User as UserEntity;

class ClientPostedRequestApplication extends Model
{
    use ModelTraits;
	
    protected $table = 'client_posted_request_applications';

    protected $guarded = [];

    protected $appends = [];

    public function postedRequest()
    {
    	return $this->hasOne(PostedRequestsEntity::class, 'id', 'posted_request_id');
    }

    public function professional()
    {
    	return $this->hasOne(UserEntity::class, 'id', 'professional_id');
    }
}
