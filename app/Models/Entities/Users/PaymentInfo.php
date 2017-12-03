<?php

namespace App\Models\Entities\Users;

use Illuminate\Database\Eloquent\Model;

class PaymentInfo extends Model
{
    protected $table = 'users_payment_infos';

    protected $guarded = [];
}
