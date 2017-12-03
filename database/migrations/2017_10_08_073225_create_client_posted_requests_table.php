<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientPostedRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_posted_requests', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('user_id')->nullable();
            $table->text('professional_types')->nullable();
            $table->string('title')->nullable();
            $table->text('message')->nullable();
            $table->date('desired_date')->nullable();
            $table->time('desired_time')->nullable();
            $table->text('servicing_area')->nullable();
            $table->text('city')->nullable();
            $table->text('state')->nullable();
            $table->float('budget', 12, 2)->nullable()->default(0);
            $table->text('service_options')->nullable();
            $table->text('current_look_photos')->nullable();
            $table->text('desired_look_photos')->nullable();
            $table->integer('professionals_applied_count')->nullable()->default(0);
            $table->integer('hired_application')->default(0);
            $table->integer('status', ['0', '1', '2'])->default('0');
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
        Schema::dropIfExists('client_posted_requests');
    }
}
