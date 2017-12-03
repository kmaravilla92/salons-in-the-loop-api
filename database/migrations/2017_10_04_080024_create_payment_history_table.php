<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_history', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->float('amount', 12, 2)->default(0);
            $table->integer('owner_id');
            $table->enum('status', ['0','1','2'])->default('0');
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
        Schema::dropIfExists('payment_history');
    }
}
