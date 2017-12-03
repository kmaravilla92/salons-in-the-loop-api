<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Entities\Image as ImageEntity;
use App\Models\Entities\Clients\Profile as ClientProfileEntity;
use App\Models\Entities\Owners\Profile as OwnerProfileEntity;
use App\Models\Entities\Professionals\Services as ServicesEntity;
use App\Models\Entities\Professionals\ServiceHours as ServiceHoursEntity;
use App\Models\Entities\Users\Review as ReviewEntity;
use App\Models\Entities\Users\PaymentInfo as PaymentInfoEntity;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','phone_number'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $guarded = [];

    protected $appends = [
        'full_name', 'profile_pic'
    ];

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getProfilePicAttribute()
    {
        $image = ImageEntity::where('type', 'user_profile_pic')->where('type_id', $this->id)->first();
        
        if($image){
            return $image->path;
        } 
        return config('app.site_url') . '/frontsite/images/sitl-img.png';
    }
    
    public function images()
    {
        return $this->hasMany(ImageEntity::class, 'type_id', 'id'); 
    }

    public function clientProfile()
    {
        return $this->hasOne(ClientProfileEntity::class, 'user_id', 'id');
    }

    public function ownerProfile()
    {
        return $this->hasOne(OwnerProfileEntity::class, 'user_id', 'id');
    }
    
    public function proServices()
    {
        return $this->hasMany(ServicesEntity::class, 'professional_id', 'id');
    }

    public function proServiceHours()
    {
        return $this->hasOne(ServiceHoursEntity::class, 'professional_id', 'id');
    }

    public function reviews()
    {
        return $this->hasMany(ReviewEntity::class, 'for_user_id', 'id');
    }

    public function paymentInfo()
    {
        return $this->hasOne(PaymentInfoEntity::class, 'user_id', 'id');
    }
}
