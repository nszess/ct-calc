<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOzoneVirusInactivationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ozone_virus_inactivations', function (Blueprint $table) {
          $table->increments('id');
          $table->unsignedTinyInteger('temperature'); //Max 255
          $table->unsignedTinyInteger('log_inactivation');  //2 digits total, 1 after .
          $table->unsignedSmallInteger('inactivation');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ozone_virus_inactivations');
    }
}
