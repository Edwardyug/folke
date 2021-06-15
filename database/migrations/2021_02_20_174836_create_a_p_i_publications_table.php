<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAPIPublicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('a_p_i_publications', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('category');
            $table->string('title');
            $table->text('description');
            $table->string('price');
            $table->string('icon');
            $table->string('slug')->unique();
            $table->unsignedBigInteger('user');
            $table->bigInteger('under_category');
            $table->dateTime('publish_at');
            $table->dateTime('stop_publish_at');
            $table->string('address');
            $table->string('lat');
            $table->string('lon');
            $table->string('img_map');
            $table->boolean('is_published');
            $table->softDeletes();

            $table->index('is_published');
            $table->foreign('category')->references('id')->on('a_p_i_categories');
            $table->foreign('user')->references('id')->on('a_p_i_users');
            $table->foreign('under_category')->references('id')->on('a_p_i_under_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('a_p_i_publications');
    }
}
