<?php

use Illuminate\Database\Seeder;

class OzoneVirusInactivationsTableSeeder extends Seeder
{


        private $entries = [
          [1, 2, 0.90],
          [1, 3, 1.40],
          [1, 4, 1.80],
          [5, 2, 0.60],
          [5, 3, 0.90],
          [5, 4, 1.20],
          [10, 2, 0.50],
          [10, 3, 0.80],
          [10, 4, 1.00],
          [15, 2, 0.30],
          [15, 3, 0.50],
          [15, 4, 0.80],
          [20, 2, 0.25],
          [20, 3, 0.40],
          [20, 4, 0.50],
          [25, 2, 0.15],
          [25, 3, 0.25],
          [25, 4, 0.30]
        ];


          /**
           * Run the database seeds.
           *
           * @return void
           */
          public function run()
          {

            foreach ($this->entries as $entry) {
                App\OzoneVirusInactivation::firstOrCreate([
                  'temperature'=>$entry[0],
                  'log_inactivation'=>$entry[1],
                  'inactivation'=>$entry[2]
                ]);
            }

          }

}
