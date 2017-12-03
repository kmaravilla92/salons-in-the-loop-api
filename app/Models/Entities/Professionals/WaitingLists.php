<?php

namespace App\Models\Entities\Professionals;

use Illuminate\Database\Eloquent\Model;
use App\Models\Entities\Traits\ModelTraits;

class WaitingLists extends Model
{
	use ModelTraits;

    protected $table = 'professional_waiting_list';

    protected $guarded = [];
}
