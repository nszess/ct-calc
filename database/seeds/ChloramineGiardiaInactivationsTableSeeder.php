<?php

use Illuminate\Database\Seeder;

class ChloramineGiardiaInactivationsTableSeeder extends Seeder
{

  private $entries = array(
    array(1, 0.5, 635),
    array(1, 1.0, 1270),
    array(1, 1.5, 1900),
    array(1, 2.0, 2535),
    array(1, 2.5, 3170),
    array(1, 3.0, 3800),

    array(5, 0.5, 365),
    array(5, 1.0, 735),
    array(5, 1.5, 1100),
    array(5, 2.0, 1470),
    array(5, 2.5, 1830),
    array(5, 3.0, 2200),

    array(10, 0.5, 310),
    array(10, 1.0, 615),
    array(10, 1.5, 930),
    array(10, 2.0, 1230),
    array(10, 2.5, 1540),
    array(10, 3.0, 1850),

    array(15, 0.5, 250),
    array(15, 1.0, 500),
    array(15, 1.5, 750),
    array(15, 2.0, 1000),
    array(15, 2.5, 1250),
    array(15, 3.0, 1500),

    array(20, 0.5, 185),
    array(20, 1.0, 370),
    array(20, 1.5, 550),
    array(20, 2.0, 735),
    array(20, 2.5, 915),
    array(20, 3.0, 1100),

    array(25, 0.5, 125),
    array(25, 1.0, 250),
    array(25, 1.5, 375),
    array(25, 2.0, 500),
    array(25, 2.5, 625),
    array(25, 3.0, 750)
  );

  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {

    foreach ($this->entries as $entry) {
        App\ChloramineGiardiaInactivation::firstOrCreate(array(
          'temperature'=>$entry[0],
          'log_inactivation'=>$entry[1],
          'inactivation'=>$entry[2]
        ));
    }

  }
}
