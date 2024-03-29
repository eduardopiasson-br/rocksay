<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->text('image_desktop')->nullable();
            $table->text('image_mobile')->nullable();
            $table->string('whatsapp', 15)->nullable();
            $table->text('facebook')->nullable();
            $table->text('instagram')->nullable();
            $table->text('site')->nullable();
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->integer('status')->default(0);
            $table->integer('position');
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
        Schema::dropIfExists('banners');
    }
}
