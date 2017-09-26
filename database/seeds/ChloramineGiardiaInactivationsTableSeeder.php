<?php

use Illuminate\Database\Seeder;

class ChloramineGiardiaInactivationsTableSeeder extends Seeder
{

  private $entries = array(
    array(1, 1, 635),
    array(1, 2, 1270),
    array(1, 3, 1900),
    array(1, 4, 2535),
    array(1, 5, 3170),
    array(1, 6, 3800),

    array(5, 1, 365),
    array(5, 2, 735),
    array(5, 3, 1100),
    array(5, 4, 1470),
    array(5, 5, 1830),
    array(5, 6, 2200),

    array(10, 1, 310),
    array(10, 2, 615),
    array(10, 3, 930),
    array(10, 4, 1230),
    array(10, 5, 1540),
    array(10, 6, 1850),

    array(15, 1, 250),
    array(15, 2, 500),
    array(15, 3, 750),
    array(15, 4, 1000),
    array(15, 5, 1250),
    array(15, 6, 1500),

    array(20, 1, 185),
    array(20, 2, 370),
    array(20, 3, 550),
    array(20, 4, 735),
    array(20, 5, 915),
    array(20, 6, 1100),

    array(25, 1, 125),
    array(25, 2, 250),
    array(25, 3, 375),
    array(25, 4, 500),
    array(25, 5, 625),
    array(25, 6, 750)
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
