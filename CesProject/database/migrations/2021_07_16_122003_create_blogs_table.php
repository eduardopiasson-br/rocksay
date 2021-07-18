<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->string('title', 150);
            $table->text('text');
            $table->date('date');
            $table->text('video')->nullable();
            $table->text('image');
            $table->dateTime('start_post');
            $table->dateTime('end_post')->nullable();
            $table->string('autor', 150)->nullable();
            $table->string('font', 150)->nullable();
            $table->text('font_link')->nullable();
            $table->string('button', 100)->nullable();
            $table->text('button_text')->nullable();
            $table->text('button_link')->nullable();
            $table->integer('highlight')->default(0);
            $table->integer('status')->default(0);
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('blogs');
    }
}
