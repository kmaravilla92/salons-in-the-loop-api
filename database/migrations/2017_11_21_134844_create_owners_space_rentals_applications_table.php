<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOwnersSpaceRentalsApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('owners_space_rentals_applications', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('professional_id');
            $table->integer('space_rental_id');
            // $table->text('proposal');
            $table->enum('application_status', ['0', '1']); // 0 = rejected, 1 = hired,
            $table->enum('status', ['0', '1']); // 0 = inactive, 1 = active
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
        Schema::dropIfExists('owners_space_rentals_applications');
    }
}
