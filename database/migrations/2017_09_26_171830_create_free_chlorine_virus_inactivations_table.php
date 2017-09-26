<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFreeChlorineVirusInactivationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('free_chlorine_virus_inactivations', function (Blueprint $table) {
          $table->increments('id');
          $table->unsignedTinyInteger('temperature');
          $table->unsignedTinyInteger('log_inactivation');
          $table->float('inactivation', 3, 1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('free_chlorine_virus_inactivations');
    }
}
