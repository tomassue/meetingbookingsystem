<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRefSignatoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ref_signatories', function (Blueprint $table) {
            $table->id();
            $table->string('honorifics')->nullable();
            $table->string('full_name');
            $table->string('title');
            $table->binary('signature'); //! Error were found where the "Data were too long for `signature`. What I did is modify the database' data type into LONGBLOB. But in Laravel migration, I don't know if it will work in BINARY. 
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
        Schema::dropIfExists('ref_signatories');
    }
}
