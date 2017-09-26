<?php

use Illuminate\Database\Seeder;

class ChlorineDioxideGiardiaInactivationsTableSeeder extends Seeder
{

  private $entries = [
    [1, 0.5, 10.0],
    [1, 1.0, 21.0],
    [1, 1.5, 32.0],
    [1, 2.0, 42.0],
    [1, 2.5, 52.0],
    [1, 3.0, 63.0],

    [5, 0.5, 4.3],
    [5, 1.0, 8.7],
    [5, 1.5, 13.0],
    [5, 2.0, 17.0],
    [5, 2.5, 22.0],
    [5, 3.0, 26.0],

    [10, 0.5, 4.0],
    [10, 1.0, 7.7],
    [10, 1.5, 12.0],
    [10, 2.0, 15.0],
    [10, 2.5, 19.0],
    [10, 3.0, 23.0],

    [15, 0.5, 3.2],
    [15, 1.0, 6.3],
    [15, 1.5, 10.0],
    [15, 2.0, 13.0],
    [15, 2.5, 16.0],
    [15, 3.0, 19.0],

    [20, 0.5, 2.5],
    [20, 1.0, 5.0],
    [20, 1.5, 7.5],
    [20, 2.0, 10.0],
    [20, 2.5, 13.0],
    [20, 3.0, 15.0],

    [25, 0.5, 2.0],
    [25, 1.0, 3.7],
    [25, 1.5, 5.5],
    [25, 2.0, 7.3],
    [25, 2.5, 9.0],
    [25, 3.0, 11.0]
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
