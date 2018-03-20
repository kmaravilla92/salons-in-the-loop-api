<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOwnerBlockedProsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('owner_blocked_pros', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('owner_id');
            $table->integer('professional_id');
            $table->enum('status', ['0', '1']); // 0 = blocked, 1 = unblocked
            $table->timeStamps();
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
        Schema::dropIfExists('owner_blocked_pros');
    }
}
