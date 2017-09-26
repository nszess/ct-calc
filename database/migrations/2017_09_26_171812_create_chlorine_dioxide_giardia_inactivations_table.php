<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChlorineDioxideGiardiaInactivationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chlorine_dioxide_giardia_inactivations', function (Blueprint $table) {
          $table->increments('id');
          $table->unsignedTinyInteger('temperature'); //Max 255
          $table->float('log_inactivation', 2, 1);  //2 digits total, 1 after .
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
        Schema::dropIfExists('chlorine_dioxide_giardia_inactivations');
    }
}
