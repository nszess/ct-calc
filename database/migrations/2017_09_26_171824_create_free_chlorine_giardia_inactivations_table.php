<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFreeChlorineGiardiaInactivationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('free_chlorine_giardia_inactivations', function (Blueprint $table) {
          $table->increments('id');
          $table->unsignedTinyInteger('temperature');
          $table->float('ph', 2, 1);
          $table->float('log_inactivation', 2, 1);
          $table->float('disinfectant_concentration', 2, 1);
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
        Schema::dropIfExists('free_chlorine_giardia_inactivations');
    }
}
