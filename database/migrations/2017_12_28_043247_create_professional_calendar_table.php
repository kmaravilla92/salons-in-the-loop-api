<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfessionalCalendarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('professional_calendar_settings', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('professional_id');
            $table->time('today_schedule_start_time')->nullable();
            $table->time('today_schedule_end_time')->nullable();
            $table->integer('duration')->default(15)->nullable();

            $table->string('morning_schedule_location')->nullable();
            $table->string('morning_schedule_other_location')->nullable();
            $table->time('morning_schedule_start_time')->nullable();
            $table->time('morning_schedule_end_time')->nullable();
            $table->text('morning_schedule_repeat_days')->nullable();

            $table->string('lunch_schedule_location')->nullable();
            $table->string('lunch_schedule_other_location')->nullable();
            $table->time('lunch_schedule_start_time')->nullable();
            $table->time('lunch_schedule_end_time')->nullable();
            $table->text('lunch_schedule_repeat_days')->nullable();

            $table->string('afternoon_schedule_location')->nullable();
            $table->string('afternoon_schedule_other_location')->nullable();
            $table->time('afternoon_schedule_start_time')->nullable();
            $table->time('afternoon_schedule_end_time')->nullable();
            $table->text('afternoon_schedule_repeat_days')->nullable();

            $table->timeStamps();
            $table->softDeletes();
        });

        Schema::create('professional_calendar_day_settings', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('professional_id');
            $table->date('date')->nullable();
            $table->time('today_schedule_start_time')->nullable();
            $table->time('today_schedule_end_time')->nullable();
            $table->integer('duration')->default(15)->nullable();

            $table->string('morning_schedule_location')->nullable();
            $table->string('morning_schedule_other_location')->nullable();
            $table->time('morning_schedule_start_time')->nullable();
            $table->time('morning_schedule_end_time')->nullable();

            $table->string('lunch_schedule_location')->nullable();
            $table->string('lunch_schedule_other_location')->nullable();
            $table->time('lunch_schedule_start_time')->nullable();
            $table->time('lunch_schedule_end_time')->nullable();

            $table->string('afternoon_schedule_location')->nullable();
            $table->string('afternoon_schedule_other_location')->nullable();
            $table->time('afternoon_schedule_start_time')->nullable();
            $table->time('afternoon_schedule_end_time')->nullable();

            $table->timeStamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('professional_calendar_settings');
        Schema::dropIfExists('professional_calendar_day_settings');
    }
}
