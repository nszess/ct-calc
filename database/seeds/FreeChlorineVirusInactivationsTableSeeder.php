<?php

use Illuminate\Database\Seeder;

class FreeChlorineVirusInactivationsTableSeeder extends Seeder
{

  private $entries = [
    [0, 2, 6.0],
    [0, 3, 9.0],
    [0, 4, 12.0],
    [5, 2, 4.0],
    [5, 3, 6.0],
    [5, 4, 8.0],
    [10, 2, 3.0],
    [10, 3, 4.0],
    [10, 4, 6.0],
    [15, 2, 2.0],
    [15, 3, 3.0],
    [15, 4, 4.0],
    [20, 2, 1.0],
    [20, 3, 2.0],
    [20, 4, 3.0],
    [25, 2, 1.0],
    [25, 3, 1.0],
    [25, 4, 2.0],
  ];

  /**
   * Run the database seeds.
   *
   * @return void
  */
  public function run()
    {

      foreach ($this->entries as $entry) {
          App\FreeChlorineVirusInactivation::firstOrCreate([
    'temperature'=>$entry[0],
    'log_inactivation'=>$entry[1],
    'inactivation'=>$entry[2]
          ]);
      }

    }

}
