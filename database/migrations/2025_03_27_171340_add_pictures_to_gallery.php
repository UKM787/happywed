<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPicturesToGallery extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('galleries', function (Blueprint $table) {
            // Add columns if they don't exist
            if (!Schema::hasColumn('galleries', 'is_picture')) {
                $table->boolean('is_picture')->default(false)->after('album_id');
            }
            if (!Schema::hasColumn('galleries', 'picture_type')) {
                $table->string('picture_type', 50)->nullable()->after('is_picture');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('galleries', function (Blueprint $table) {
            $table->dropColumn(['is_picture', 'picture_type']);
        });
    }
}
