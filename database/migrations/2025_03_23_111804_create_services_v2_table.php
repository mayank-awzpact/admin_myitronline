<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('services_v2', function (Blueprint $table) {
            $table->ustring('unique_id')->unique();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('service_heading');
            $table->text('description');
            $table->text('full_description');
            $table->decimal('service_price', 10, 2);
            $table->decimal('service_tax', 10, 2)->nullable();
            $table->decimal('percent_save', 5, 2)->nullable();
            $table->tinyInteger('status')->default(0); // 0 = Unpublished, 1 = Published, 2 = Draft
            $table->string('offer_dates')->nullable();
            
            // SEO Fields
            $table->string('seo_title');
            $table->text('seo_description');
            $table->enum('index', ['Index', 'No_Index']);
            
            // JSON fields for service sections and FAQs
            $table->json('service_sections');
            $table->json('faq_fields')->nullable();
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('services_v2');
    }
};
