<?php

namespace App\Models\Entities\Owners;

use Illuminate\Database\Eloquent\Model;

class SpaceRentalApplication extends Model
{
    protected $table = 'owners_space_rentals_applications';

    protected $guarded = [];

    public function professional()
    {
    	return $this->hasOne(UserEntity::class, 'id', 'professional_id');
    }
}
