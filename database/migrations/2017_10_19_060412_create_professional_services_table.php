<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfessionalServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('professional_services', function(Blueprint $table) 
        {
            $table->increments('id');
            $table->integer('professional_id');
            $table->string('service_name');
            $table->float('duration', 12, 2);
            $table->float('price', 12, 2);
            $table->enum('status', ['0', '1']); // 0 = not visible, 1 = visible
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
        Schema::dropIfExists('professional_services');
    }
}
