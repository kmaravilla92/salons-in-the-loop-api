<?php

namespace App\Models\Entities\Professionals;

use Illuminate\Database\Eloquent\Model;
use App\Models\Entities\Owners\HelpRequest as HelpRequestEntity;
use App\Models\Entities\Traits\ModelTraits;

class OwnerPostedHelpRequestApplication extends Model
{
    use ModelTraits;
	
    protected $table = 'owners_help_requests_applications';

    protected $guarded = [];

    protected $appends = [];

    public function postedHelpRequest()
    {
    	return $this->hasOne(HelpRequestEntity::class, 'id', 'help_request_id');
    }
}
