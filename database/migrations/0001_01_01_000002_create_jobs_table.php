<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
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
        Schema::create('article_goods', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('article_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps(0);
            $table->foreign('article_id')->references('id')->on('articles')->onDelete('restrict');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');
        });

        Schema::create('article_images', function (Blueprint $table) {
            $table->id();
            $table->string('image_path', 255);
            $table->timestamps(0);
            // The original SQL dump uses `id` as the foreign key which seems incorrect
            // Adding a new `article_id` column to reference the `articles` table
            $table->unsignedBigInteger('article_id');
            $table->foreign('article_id')->references('id')->on('articles')->onDelete('restrict');
        });

        Schema::create('article_comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('article_id');
            $table->unsignedBigInteger('user_id');
            $table->text('body');
            $table->boolean('deleted_flag')->default(0);
            $table->timestamps(0);
            $table->foreign('article_id')->references('id')->on('articles')->onDelete('restrict');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');
        });
        // Schema::create('jobs', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('queue')->index();
        //     $table->longText('payload');
        //     $table->unsignedTinyInteger('attempts');
        //     $table->unsignedInteger('reserved_at')->nullable();
        //     $table->unsignedInteger('available_at');
        //     $table->unsignedInteger('created_at');
        // });

        // Schema::create('job_batches', function (Blueprint $table) {
        //     $table->string('id')->primary();
        //     $table->string('name');
        //     $table->integer('total_jobs');
        //     $table->integer('pending_jobs');
        //     $table->integer('failed_jobs');
        //     $table->longText('failed_job_ids');
        //     $table->mediumText('options')->nullable();
        //     $table->integer('cancelled_at')->nullable();
        //     $table->integer('created_at');
        //     $table->integer('finished_at')->nullable();
        // });

        // Schema::create('failed_jobs', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('uuid')->unique();
        //     $table->text('connection');
        //     $table->text('queue');
        //     $table->longText('payload');
        //     $table->longText('exception');
        //     $table->timestamp('failed_at')->useCurrent();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('article_goods');
        Schema::dropIfExists('article_images');
        Schema::dropIfExists('articles');
        Schema::dropIfExists('article_comments');
        // Schema::dropIfExists('jobs');
        // Schema::dropIfExists('job_batches');
        // Schema::dropIfExists('failed_jobs');
    }
};
