<?php

namespace App\Models\Entities\Users;

use Illuminate\Database\Eloquent\Model;
use App\User as UserEntity;
use App\Models\Entities\Image as ImageEntity;

class Review extends Model
{
	
	protected $table = 'user_reviews';

    protected $guarded = [];

    protected $appends = [
    	'overall_rating_formatted'
   	];

    public function reviewer()
    {
    	return $this->hasOne(UserEntity::class, 'id', 'by_user_id');
    }

    public function receiver()
    {
    	return $this->hasOne(UserEntity::class, 'id', 'for_user_id');
    }

    public function images()
    {
        return $this->hasMany(ImageEntity::class, 'type_id', 'id');
    }

    public function setOverallRatingAttribute($value)
    {
        $this->attributes['overall_rating'] = collect($this->attributes)->only(['quality_of_service','professionalism','value'])->avg();
    }

    public function setRecordTypeAttribute($value)
    {
        $this->attributes['record_type'] = config('settings.reviews.record_types.' . $value);
    }

    public function getCreatedAtAttribute()
    {
        return date('m/d/Y', strtotime($this->attributes['created_at']));
    }

    public function getOverallRatingFormattedAttribute()
    {
        $overall_rating = $this->attributes['overall_rating'];
        return number_format($overall_rating, 1, '.', ',');
    }
}
