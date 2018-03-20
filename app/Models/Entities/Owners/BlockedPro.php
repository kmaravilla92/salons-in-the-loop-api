<?php

namespace App\Models\Entities\Owners;

use Illuminate\Database\Eloquent\Model;
use App\Models\Entities\Traits\ModelTraits;
use App\User as UserEntity;

class BlockedPro extends Model
{
	use ModelTraits;
	
    protected $table = 'owner_blocked_pros';

    protected $fillable = [];

    protected $guarded = [];

    protected $appends = [];
}
