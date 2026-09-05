<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_office_event', function (Blueprint $table) {
            $table->id('uniqueId');
            $table->string('eventTitle', 256);
            $table->string('eventSlug', 256)->nullable();
            $table->string('eventType', 50)->default('event');
            $table->date('eventDate');
            $table->date('eventEndDate')->nullable();
            $table->string('eventTime', 50)->nullable();
            $table->string('eventVenue', 256)->nullable();
            $table->string('employeeName', 256)->nullable();
            $table->string('eventImage', 256)->nullable();
            $table->longText('eventDescription')->nullable();
            $table->integer('isHoliday')->default(0);
            $table->integer('isRecurring')->default(0);
            $table->integer('priority')->nullable();
            $table->integer('status')->default(1);
            $table->integer('createdOn')->nullable();
            $table->integer('createdBy')->nullable();
            $table->integer('updatedOn')->nullable();
            $table->integer('updatedBy')->nullable();
            $table->integer('isTrashed')->default(0);
            $table->integer('TrashedOn')->nullable();

            $table->index(['eventDate']);
            $table->index(['status', 'isTrashed']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_office_event');
    }
};
