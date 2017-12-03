<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfessionalWaitingListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('professional_waiting_list', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('professional_id')->nullable();
            $table->string('title')->nullable();
            $table->text('message')->nullable();
            $table->string('phone_number', 50)->nullable();
            $table->timestamps();
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
        Schema::dropIfExists('professional_waiting_list');
    }
}
