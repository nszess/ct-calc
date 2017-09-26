<?php

use Illuminate\Database\Seeder;

class ChlorineDioxideVirusInactivationsTableSeeder extends Seeder
{

    private $entries = [
      [1, 2, 8.4],
      [1, 3, 25.6],
      [1, 4, 50.1],
      [5, 2, 5.6],
      [5, 3, 17.1],
      [5, 4, 33.4],
      [10, 2, 4.2],
      [10, 3, 12.8],
      [10, 4, 25.1],
      [15, 2, 2.8],
      [15, 3, 8.6],
      [15, 4, 16.7],
      [20, 2, 2.1],
      [20, 3, 6.4],
      [20, 4, 12.5],
      [25, 2, 1.4],
      [25, 3, 4.3],
      [25, 4, 8.4]
    ];


      /**
       * Run the database seeds.
       *
       * @return void
       */
      public function run()
      {

        foreach ($this->entries as $entry) {
            App\ChlorineDioxideVirusInactivation::firstOrCreate([
              'temperature'=>$entry[0],
              'log_inactivation'=>$entry[1],
              'inactivation'=>$entry[2]
            ]);
        }

      }
}
