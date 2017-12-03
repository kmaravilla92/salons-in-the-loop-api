<?php

namespace App\Models\Entities\Clients;

use Illuminate\Database\Eloquent\Model;
use App\Models\Entities\Traits\ModelTraits;
use App\User as UserEntity;

class Profile extends Model
{
	use ModelTraits;
	
    protected $table = 'clients_profiles';

    protected $fillable = [
    	'user_id',
        'address',
        'city',
        'state',
        'zip_code',
        'allergy_list',
        'chemical_list',
        'likes',
        'dislikes',
    ];

    protected $guarded = [
    	// 
    ];

    protected $appends = [
    	'full_address'
   	];

    public function getFullAddressAttribute()
    {
    	return $this->address . ' ,' . $this->city . ' ,' . $this->state . ' ,' . $this->zip_code;
    }
}
