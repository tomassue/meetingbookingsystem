<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblMeetingFeedbackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_meeting_feedback', function (Blueprint $table) {
            $table->id();
            $table->string('id_booking_no'); # FK from tbl_booked_meetings
            $table->integer('attendee'); # FK from users. Usually, they are the department heads / attendees.
            $table->integer('meeting_status'); # 0 - Declined; 1 - Accepted
            $table->string('proxy')->nullable(); # NULL - if the department head didn't send someone(representative) as proxy.
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
        Schema::dropIfExists('tbl_meeting_feedback');
    }
}
