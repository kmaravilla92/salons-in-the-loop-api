<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_reviews', function(Blueprint $table)
        {
            $table->increments('id');
            $table->text('feedback')->nullable();
            $table->integer('quality_of_service')->default(0);
            $table->integer('professionalism')->default(0);
            $table->integer('value')->default(0);
            $table->float('overall_rating', 10, 2)->default(0);
            $table->boolean('recommended')->default(0);
            $table->integer('by_user_id')->default(0);
            $table->integer('for_user_id')->default(0);
            $table->integer('_reserved_id_')->default(0);
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
        Schema::dropIfExists('users_reviews');
    }
}
