<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticleImagesTable extends Migration
{
    public function up()
    {
        Schema::create('article_images', function (Blueprint $table) {
            $table->id();
            $table->string('image_path', 255);
            $table->timestamps(0);
            // The original SQL dump uses `id` as the foreign key which seems incorrect
            // Adding a new `article_id` column to reference the `articles` table
            $table->unsignedBigInteger('article_id');
            $table->foreign('article_id')->references('id')->on('articles')->onDelete('restrict');
        });
    }

    public function down()
    {
        Schema::dropIfExists('article_images');
    }
}
