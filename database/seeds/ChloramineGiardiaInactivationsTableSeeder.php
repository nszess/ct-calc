<?php

use Illuminate\Database\Seeder;

class ChloramineGiardiaInactivationsTableSeeder extends Seeder
{

  private $entries = [
    [1, 0.5, 635],
    [1, 1.0, 1270],
    [1, 1.5, 1900],
    [1, 2.0, 2535],
    [1, 2.5, 3170],
    [1, 3.0, 3800],

    [5, 0.5, 365],
    [5, 1.0, 735],
    [5, 1.5, 1100],
    [5, 2.0, 1470],
    [5, 2.5, 1830],
    [5, 3.0, 2200],

    [10, 0.5, 310],
    [10, 1.0, 615],
    [10, 1.5, 930],
    [10, 2.0, 1230],
    [10, 2.5, 1540],
    [10, 3.0, 1850],

    [15, 0.5, 250],
    [15, 1.0, 500],
    [15, 1.5, 750],
    [15, 2.0, 1000],
    [15, 2.5, 1250],
    [15, 3.0, 1500],

    [20, 0.5, 185],
    [20, 1.0, 370],
    [20, 1.5, 550],
    [20, 2.0, 735],
    [20, 2.5, 915],
    [20, 3.0, 1100],

    [25, 0.5, 125],
    [25, 1.0, 250],
    [25, 1.5, 375],
    [25, 2.0, 500],
    [25, 2.5, 625],
    [25, 3.0, 750]
  ];

  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {

    foreach ($this->entries as $entry) {
        App\ChloramineGiardiaInactivation::firstOrCreate([
          'temperature'=>$entry[0],
          'log_inactivation'=>$entry[1],
          'inactivation'=>$entry[2]
        ]);
    }

  }
}
