<?php

namespace App\Models\Entities\Owners;

use Illuminate\Database\Eloquent\Model;
use App\User as UserEntity;

class HelpRequestApplication extends Model
{
    protected $table = 'owners_help_requests_applications';

    protected $guarded = [];

    public function professional()
    {
    	return $this->hasOne(UserEntity::class, 'id', 'professional_id');
    }
}
