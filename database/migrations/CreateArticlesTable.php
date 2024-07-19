<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('hash', 16);
            $table->string('title', 50);
            $table->text('contents');
            $table->boolean('port_stauts_flag');
            $table->boolean('delete_flag');
            $table->integer('views');
            $table->timestamps(0); // Default timestamp precision
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');
        });
    }

    public function down()
    {
        Schema::dropIfExists('articles');
    }
}
