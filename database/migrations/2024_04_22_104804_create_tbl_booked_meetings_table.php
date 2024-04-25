<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblBookedMeetingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_booked_meetings', function (Blueprint $table) {
            // $table->id();
            $table->string('booking_no'); // Primary Key
            $table->dateTime('start_date_time');
            $table->dateTime('end_date_time');
            $table->string('type_of_attendees');
            $table->string('attendees');
            $table->string('subject');
            $table->string('id_file_data'); # We will be storing array here. Same goes with the attendees.
            $table->longText('meeting_description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_booked_meetings');
    }
}
