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
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->text('selected_days')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->enum('allow_reoccuring', ['0', '1'])->default('0')->nullable(); // 0 = no, 1 = yes
            $table->string('license_image_path')->nullable();
            $table->text('message_to_salon_owner')->nullable();
            $table->enum('application_status', ['0', '1']); // 0 = rejected, 1 = hired, 2 = cancelled
            $table->enum('status', ['0', '1']); // 0 = inactive, 1 = active,
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
