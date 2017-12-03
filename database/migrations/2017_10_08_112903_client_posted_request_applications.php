<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ClientPostedRequestApplications extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_posted_request_applications', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('professional_id');
            $table->integer('posted_request_id');
            $table->text('proposal');
            $table->enum('application_status', ['0', '1']); // 0 = rejected, 1 = hired,
            $table->enum('status', ['0', '1', '2']); // 0 = inactive, 1 = active
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
        Schema::dropIfExists('client_posted_request_applications');
    }
}
