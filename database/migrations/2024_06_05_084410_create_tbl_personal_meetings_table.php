<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblPersonalMeetingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_personal_meetings', function (Blueprint $table) {
            // $table->id();
            $table->string('booking_no')->primary();
            $table->dateTime('start_date_time');
            $table->dateTime('end_date_time');
            $table->string('subject');
            $table->longText('description')->nullable();
            $table->string('id_user', 5); //* The second parameter indicates the length/set of the column.
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
        Schema::dropIfExists('tbl_personal_meetings');
    }
}
