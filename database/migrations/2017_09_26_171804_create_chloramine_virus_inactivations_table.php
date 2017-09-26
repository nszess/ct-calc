<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChloramineVirusInactivationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chloramine_virus_inactivations', function (Blueprint $table) {
          $table->increments('id');
          $table->unsignedTinyInteger('temperature'); //Max 255
          $table->unsignedTinyInteger('log_inactivation'); //Max 255
          $table->unsignedSmallInteger('inactivation');  //Max 65535
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chloramine_virus_inactivations');
    }
}
