<?php

namespace App\Http\Controllers\Rest\Professional;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Entities\Professionals\CalendarSetting as CalendarSettingEntity;
use App\Models\Entities\Professionals\CalendarDaySetting as CalendarDaySettingEntity;

class CalendarDaySettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($pro_id, Request $request)
    {
        $schedules = CalendarDaySettingEntity::where('professional_id', $pro_id)->get();
        return $schedules->map(function($schedule)
            {
                return [
                    [
                        'title'=>!empty($schedule->morning_schedule_other_location) ? $schedule->morning_schedule_other_location : $schedule->morning_schedule_location,
                        'start'=>$schedule->date,
                        'end'=>$schedule->date,
                        'cssClass' => ''
                    ],
                    [
                        'title'=>!empty($schedule->lunch_schedule_other_location) ? $schedule->lunch_schedule_other_location : $schedule->lunch_schedule_location,
                        'start'=>$schedule->date,
                        'end'=>$schedule->date,
                        'cssClass' => ''
                    ],
                    [
                        'title'=>!empty($schedule->afternoon_schedule_other_location) ? $schedule->afternoon_schedule_other_location : $schedule->afternoon_schedule_location,
                        'start'=>$schedule->date,
                        'end'=>$schedule->date,
                        'cssClass' => ''
                    ],
                ];
            })
            ->flatten(1)
            ->all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($pro_id, Request $request)
    {
        $settings = $request->input('settings');
        
        CalendarDaySettingEntity::updateOrCreate(
            [
                'professional_id'=> $pro_id,
                'date' => $settings['date']
            ], 
            $request->input('settings')
        );
        return [
            'success' => true
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($pro_id, $date, Request $request)
    {
        $data = [
            'date' => $date,
            'professional_id'=>$pro_id,
            'today_schedule_start_time'=>'',
            'today_schedule_end_time'=>'',
            'duration'=> 15,

            'morning_schedule_location'=>'',
            'morning_schedule_other_location'=>'',
            'morning_schedule_start_time'=>'',
            'morning_schedule_end_time'=>'',

            'lunch_schedule_location'=>'',
            'lunch_schedule_other_location'=>'',
            'lunch_schedule_start_time'=>'',
            'lunch_schedule_end_time'=>'',

            'afternoon_schedule_location'=>'',
            'afternoon_schedule_other_location'=>'',
            'afternoon_schedule_start_time'=>'',
            'afternoon_schedule_end_time'=>'',
        ];
        return CalendarDaySettingEntity::firstOrNew([
                'date'=>$date,
                'professional_id'=>$pro_id
            ], $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
