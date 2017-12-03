<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientProfileViewRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_profile_view_requests', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('client_id');
            $table->integer('viewer_id');
            $table->enum('status', ['0' ,'1', '2']); // 0 = new, 1 = accepted, 2 = rejected
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
        Schema::dropIfExists('client_profile_view_requests');
    }
}
