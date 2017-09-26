<?php

use Illuminate\Database\Seeder;

class ChlorineDioxideGiardiaInactivationsTableSeeder extends Seeder
{

  private $entries = [
    [1, 1, 10.0],
    [1, 2, 21.0],
    [1, 3, 32.0],
    [1, 4, 42.0],
    [1, 5, 52.0],
    [1, 6, 63.0],

    [5, 1, 4.3],
    [5, 2, 8.7],
    [5, 3, 13.0],
    [5, 4, 17.0],
    [5, 5, 22.0],
    [5, 6, 26.0],

    [10, 1, 4.0],
    [10, 2, 7.7],
    [10, 3, 12.0],
    [10, 4, 15.0],
    [10, 5, 19.0],
    [10, 6, 23.0],

    [15, 1, 3.2],
    [15, 2, 6.3],
    [15, 3, 10.0],
    [15, 4, 13.0],
    [15, 5, 16.0],
    [15, 6, 19.0],

    [20, 1, 2.5],
    [20, 2, 5.0],
    [20, 3, 7.5],
    [20, 4, 10.0],
    [20, 5, 13.0],
    [20, 6, 15.0],

    [25, 1, 2.0],
    [25, 2, 3.7],
    [25, 3, 5.5],
    [25, 4, 7.3],
    [25, 5, 9.0],
    [25, 6, 11.0]
  ];


    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

      foreach ($this->entries as $entry) {
          App\ChlorineDioxideGiardiaInactivation::firstOrCreate([
            'temperature'=>$entry[0],
            'log_inactivation'=>$entry[1],
            'inactivation'=>$entry[2]
          ]);
      }

    }
}
