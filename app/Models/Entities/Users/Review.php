<?php

namespace App\Models\Entities\Users;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{

	protected $table = 'users_reviews';

    protected $guarded = [];
}
