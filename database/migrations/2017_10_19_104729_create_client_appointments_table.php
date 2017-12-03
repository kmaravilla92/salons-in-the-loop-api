<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_appointments', function(Blueprint $table) 
        {
            $table->increments('id');
            $table->integer('client_id')->nullable();
            $table->integer('professional_id')->nullable();
            $table->float('total_price', 12, 2)->nullable();
            $table->float('total_duration', 12, 2)->nullable();
            $table->enum('status', ['0', '1']); // 0 = unpaid, 1 = paid
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('client_appointment_selected_services', function(Blueprint $table) 
        {
            $table->increments('id');
            $table->integer('client_appointment_id');
            $table->integer('professional_service_id');
            $table->text('additional_notes')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('client_appointment_selected_date_time', function(Blueprint $table) 
        {
            $table->increments('id');
            $table->integer('client_appointment_id');
            $table->dateTime('booking_date_time')->nullable();
            $table->text('location')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('client_appointments');
        Schema::dropIfExists('client_appointment_selected_services');
        Schema::dropIfExists('client_appointment_selected_date_time');
    }
}
