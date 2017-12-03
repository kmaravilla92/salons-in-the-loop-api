<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersPaymentInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_payment_infos', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('cc_name')->nullable();
            $table->string('cc_number')->nullable();
            $table->string('cc_exp_month')->nullable();
            $table->string('cc_exp_year')->nullable();
            $table->string('cc_sec_code')->nullable();
            $table->string('cc_type')->nullable();
            $table->string('billing_address')->nullable();
            $table->string('billing_city')->nullable();
            $table->string('billing_postal')->nullable();
            $table->string('billing_state')->nullable();
            $table->string('billing_country')->nullable();
            $table->integer('user_id');
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
        Schema::dropIfExists('users_payment_infos');
    }
}
