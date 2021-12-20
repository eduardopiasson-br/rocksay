<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDefaultConfigurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('default_configurations', function (Blueprint $table) {
            $table->id();
            $table->string('owner', 150)->nullable();
            $table->string('cnpj', 100);
            $table->string('address', 250);
            $table->text('link_address')->nullable();
            $table->text('footer_text');
            $table->string('phone', 15)->nullable();
            $table->string('whatsapp', 15)->nullable();
            $table->string('telegram', 15)->nullable();
            $table->text('instagram')->nullable();
            $table->text('facebook')->nullable();
            $table->string('email', 100);
            $table->string('email_two', 100)->nullable();
            $table->text('wellcome_message')->nullable();
            $table->text('image')->nullable();
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
        Schema::dropIfExists('default_configurations');
    }
}
