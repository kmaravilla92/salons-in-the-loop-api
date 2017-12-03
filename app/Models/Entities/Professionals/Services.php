<?php

namespace App\Models\Entities\Professionals;

use Illuminate\Database\Eloquent\Model;
use App\Models\Entities\Traits\ModelTraits;

class Services extends Model
{
	use ModelTraits;
	
    protected $table = 'professional_services';

    protected $guarded = [];
}
