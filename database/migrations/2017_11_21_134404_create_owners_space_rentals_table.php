<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOwnersSpaceRentalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('owners_space_rentals', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('owner_id')->nullable();
            $table->string('category')->nullable();
            $table->string('title');
            $table->text('description')->nullable();
            $table->integer('number_of_occupied_spaces')->default(0)->nullable();
            $table->integer('number_of_spaces')->default(0)->nullable();
            $table->enum('rate', ['0', '1', '2', '3'])->nullable()->default('0');
            $table->float('rate_price', 12, 2)->nullable()->default(0);
            $table->text('selected_days')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->text('requirements')->nullable();
            $table->integer('renters_count')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        // Schema::create('owners_space_rentals_hired_applications', function (Blueprint $table) {
        //     $table->increments('id');
        //     $table->integer('application_id');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('owners_space_rentals');
        // Schema::dropIfExists('owners_space_rentals_hired_applications');
    }
}
