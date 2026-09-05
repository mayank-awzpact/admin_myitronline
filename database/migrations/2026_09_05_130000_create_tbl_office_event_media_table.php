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
        Schema::create('tbl_office_event_media', function (Blueprint $table) {
            $table->id('uniqueId');
            $table->unsignedBigInteger('eventId');
            $table->string('mediaType', 20)->default('image');
            // Uploaded file path (public/uploads/...) OR an external url
            // (Google Drive file, YouTube, Vimeo or a direct .mp4 / .jpg link)
            $table->string('mediaPath', 512);
            $table->string('mediaThumb', 512)->nullable();
            $table->string('mediaCaption', 256)->nullable();
            $table->integer('priority')->nullable();
            $table->integer('status')->default(1);
            $table->integer('createdOn')->nullable();
            $table->integer('createdBy')->nullable();
            $table->integer('isTrashed')->default(0);
            $table->integer('TrashedOn')->nullable();

            $table->index(['eventId', 'status', 'isTrashed'], 'office_event_media_event_index');
        });

        Schema::table('tbl_office_event', function (Blueprint $table) {
            // Optional full album link, e.g. a shared Google Drive folder
            $table->string('driveUrl', 512)->nullable()->after('eventImage');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_office_event', function (Blueprint $table) {
            $table->dropColumn('driveUrl');
        });

        Schema::dropIfExists('tbl_office_event_media');
    }
};
