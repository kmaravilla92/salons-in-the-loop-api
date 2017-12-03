<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('service_payments', function (Blueprint $table) {
        //     $table->increments('id');
        //     $table->string('service_type');
        //     $table->integer('service_id');
        //     $table->enum('payment_method', ['paypal', 'credit_card']);
        //     $table->timestamps();
        //     $table->softDeletes();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_payments');
    }
}
