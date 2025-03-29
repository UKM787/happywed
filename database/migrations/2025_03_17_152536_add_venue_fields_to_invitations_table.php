<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVenueFieldsToInvitationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invitations', function (Blueprint $table) {
            $table->string('venueName')->nullable();
            $table->string('venueAddress')->nullable();
            $table->string('venuePincode')->nullable();
            $table->string('venueCity')->nullable();
            $table->string('venueState')->nullable();
            $table->string('venueLandmark')->nullable();
            $table->string('venueStreet')->nullable();
            $table->string('venueMobile')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invitations', function (Blueprint $table) {
            $table->dropColumn([
                'venuePincode',
                'venueCity',
                'venueState',
                'venueLandmark',
                'venueStreet'
            ]);
        });
    }
}
