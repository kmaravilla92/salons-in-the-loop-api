<?php

namespace App\Models\Entities\Professionals;

use Illuminate\Database\Eloquent\Model;
use App\Models\Entities\Traits\ModelTraits;
use App\User as UserEntity;

class CalendarSetting extends Model
{
    use ModelTraits;
	
    protected $table = 'professional_calendar_settings';

    protected $guarded = [];

    protected $appends = [];

    public function owner()
    {
    	return $this->hasOne(UserEntity::class, 'id', 'professional_id');
    }

    public function getMorningScheduleRepeatDaysAttribute($value)
	{
		return json_decode($this->attributes['morning_schedule_repeat_days']);
	}

	public function getLunchScheduleRepeatDaysAttribute($value)
	{
		return json_decode($this->attributes['lunch_schedule_repeat_days']);
	}

	public function getAfternoonScheduleRepeatDaysAttribute($value)
	{
		return json_decode($this->attributes['afternoon_schedule_repeat_days']);
	}

    public function setTodayScheduleStartTimeAttribute($value)
	{
		$this->attributes['today_schedule_start_time'] = date('H:i:s', strtotime($value));
	}

	public function setTodayScheduleEndTimeAttribute($value)
	{
		$this->attributes['today_schedule_end_time'] = date('H:i:s', strtotime($value));
	}

	public function setMorningScheduleStartTimeAttribute($value)
	{
		$this->attributes['morning_schedule_start_time'] = date('H:i:s', strtotime($value));
	}

	public function setMorningScheduleEndTimeAttribute($value)
	{
		$this->attributes['morning_schedule_end_time'] = date('H:i:s', strtotime($value));
	}

	public function setLunchScheduleStartTimeAttribute($value)
	{
		$this->attributes['lunch_schedule_start_time'] = date('H:i:s', strtotime($value));
	}

	public function setLunchScheduleEndTimeAttribute($value)
	{
		$this->attributes['lunch_schedule_end_time'] = date('H:i:s', strtotime($value));
	}

	public function setAfternoonScheduleStartTimeAttribute($value)
	{
		$this->attributes['afternoon_schedule_start_time'] = date('H:i:s', strtotime($value));
	}

	public function setAfternoonScheduleEndTimeAttribute($value)
	{
		$this->attributes['afternoon_schedule_end_time'] = date('H:i:s', strtotime($value));
	}

    public function setMorningScheduleRepeatDaysAttribute($value)
    {
    	$this->attributes['morning_schedule_repeat_days'] = json_encode($value);
    }

    public function setLunchScheduleRepeatDaysAttribute($value)
    {
    	$this->attributes['lunch_schedule_repeat_days'] = json_encode($value);
    }

    public function setAfternoonScheduleRepeatDaysAttribute($value)
    {
    	$this->attributes['afternoon_schedule_repeat_days'] = json_encode($value);
    }
}
