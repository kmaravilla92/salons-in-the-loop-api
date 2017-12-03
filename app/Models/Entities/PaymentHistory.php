<?php

namespace App\Models\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Models\Entities\Traits\ModelTraits;

class PaymentHistory extends Model
{

	use ModelTraits;

	protected $table = 'payment_history';

 	protected $guarded = [];  

 	protected $appends = ['date'];

 	public function getDateAttribute($value)
 	{
 		return date('m/d/Y', strtotime($this->attributes['created_at']));
 	}

 	public function getAmountAttribute($value)
 	{
 		return number_format($value, 2, '.', ',');
 	} 
}
