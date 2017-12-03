<?php

namespace App\Models\Entities\Owners;

use Illuminate\Database\Eloquent\Model;
use App\Models\Entities\Traits\ModelTraits;
use App\User as UserEntity;

class Profile extends Model
{
	use ModelTraits;
	
    protected $table = 'owners_profiles';

    protected $fillable = [
        'user_id',
        'category',
        'business_name',
        'title',
        'name',
        'address',
        'city',
        'state',
        'general_space_description'
    ];

    protected $guarded = [];

    protected $appends = [
    	'full_address',
        'category_decoded'
   	];

    public function getGeneralSpaceDescriptionAttribute()
    {
        if(empty($this->general_space_description))
            return 'No description';
        return $this->general_space_description;
    }

    public function getFullAddressAttribute()
    {
        $address = $this->address . ($this->address ? ' ,' : '' ) . $this->city . ($this->city ? ' ,' : '' ) . $this->state;
    	return empty($address) ? 'N\A' : $address;
    }

    public function getCategoryDecodedAttribute()
    {
        if(empty($this->category)){
            $this->category = '[]';
        }
        return json_decode($this->category);
    }
}
