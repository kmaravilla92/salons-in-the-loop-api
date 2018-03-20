<?php

namespace App\Models\Entities\Professionals;

use Illuminate\Database\Eloquent\Model;
use App\Models\Entities\Traits\ModelTraits;
use App\User as UserEntity;
use App\Models\Entities\Owners\BlockedPro as BlockedProEntity;
use App\Models\Entities\Users\Review as ReviewEntity;

class Profile extends Model
{
    use ModelTraits;
	
    protected $table = 'professionals_profiles';

    protected $guarded = [];

    protected $appends = [
    	'full_address',
    	'category_decoded',
        'category_csv',
        'review_rating_count'
   	];

    public function ownerBlocking()
    {
        return $this->hasMany(BlockedProEntity::class, 'professional_id', 'user_id');
    }

    public function getFullAddressAttribute()
    {
        $address = $this->address . ($this->address ? ' ,' : '' ) . $this->city . ($this->city ? ' ,' : '' ) . $this->state;
    	// return empty($address) ? 'N\A' : $address;
        return $address;
    }

    public function getCategoryDecodedAttribute()
    {
        if(empty($this->category)){
            $this->category = '[]';
        }
        return json_decode($this->category);
    }

    public function getCategoryCsvAttribute()
    {
        return join($this->category_decoded, ',');
    }

    public function getReviewRatingCountAttribute()
    {
        $reviews = ReviewEntity::where('for_user_id', $this->attributes['user_id'])->get();
        $overall_rating = round($reviews->avg('overall_rating'));
        return number_format($overall_rating, 1, '.', ',');
    }
}
