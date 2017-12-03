<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOwnersHelpRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('owners_help_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('owner_id')->nullable();
            $table->string('category')->nullable();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->enum('rate', ['0', '1', '2', '3'])->nullable()->default('0');
            $table->float('weekly_total', 12, 2)->nullable()->default(0);
            $table->text('selected_days')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->text('service_options')->nullable();
            $table->integer('professionals_applied_count')->default(0);
            $table->integer('hired_application')->default(0);
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
        Schema::dropIfExists('owners_help_requests');
    }
}
