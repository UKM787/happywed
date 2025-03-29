<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPictureFieldsToGalleriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('galleries', function (Blueprint $table) {
            // First add is_picture column
            if (!Schema::hasColumn('galleries', 'is_picture')) {
                $table->boolean('is_picture')->default(false);
            }
            
            // Then add picture_type column
            if (!Schema::hasColumn('galleries', 'picture_type')) {
                $table->string('picture_type')->default('gallery');
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