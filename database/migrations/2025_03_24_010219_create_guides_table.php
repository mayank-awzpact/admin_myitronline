<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('guides', function (Blueprint $table) {
            $table->bigIncrements('uniqueId'); // Auto-increment primary key
            $table->string('horizontal_category');
            $table->string('vertical_category');
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('guide_heading');
            $table->enum('status', ['1', '0', '2'])->default('2'); // Published, Unpublished, Draft
            $table->text('description');
            $table->string('intro_image');
            $table->string('full_article_image');
            $table->json('service_sections')->nullable();
            $table->json('faq_fields')->nullable();
            $table->string('meta_title');
            $table->string('robots');
            $table->text('meta_keyword');
            $table->text('tags');
            $table->text('meta_description');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('guides');
    }
};
