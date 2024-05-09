<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblMemoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_memo', function (Blueprint $table) {
            $table->id();
            $table->string('id_booking_no')->unique(); # FK from tbl_booked_meeting. We will be accessing some info from this table. This is also connected to tbl_feedback_meeting.
            // $table->string('subject'); # Though it is auto-filled (data from tbl_booked_meeting), we will give the admin the option to edit it in case of typos or grammatically errors.
            $table->longText('message'); # Though it is auto-filled (data from tbl_booked_meeting), we will give the admin the option to edit it in case of typos or grammatically errors.
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
        Schema::dropIfExists('tbl_memo');
    }
}
