<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfessionalsProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('professionals_profiles', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('user_id');
            $table->text('category')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zipcode')->nullable();
            $table->text('cancellation_policy')->nullable();
            $table->string('social_link_facebook')->nullable();
            $table->string('social_link_instagram')->nullable();
            $table->string('social_link_twitter')->nullable();
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
        Schema::dropIfExists('professionals_profiles');
    }
}
