<?php

namespace App\Models\Entities\Professionals;

use Illuminate\Database\Eloquent\Model;
use App\Models\Entities\Owners\SpaceRental as SpaceRentalEntity;
use App\Models\Entities\Traits\ModelTraits;

class ClientPostedRentalApplication extends Model
{
    use ModelTraits;
	
    protected $table = 'owners_space_rentals_applications';

    protected $guarded = [];

    protected $appends = [];

    public function postedRental()
    {
    	return $this->hasOne(SpaceRentalEntity::class, 'id', 'space_rental_id');
    }
}
