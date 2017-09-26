<?php

use Illuminate\Database\Seeder;

class OzoneGiardiaInactivationsTableSeeder extends Seeder
{

      private $entries = [
        [1, 0.5, 0.48],
        [1, 1.0, 0.97],
        [1, 1.5, 1.50],
        [1, 2.0, 1.90],
        [1, 2.5, 2.40],
        [1, 3.0, 2.90],

        [5, 0.5, 0.32],
        [5, 1.0, 0.63],
        [5, 1.5, 0.95],
        [5, 2.0, 1.30],
        [5, 2.5, 1.60],
        [5, 3.0, 1.90],

        [10, 0.5, 0.23],
        [10, 1.0, 0.48],
        [10, 1.5, 0.72],
        [10, 2.0, 0.95],
        [10, 2.5, 1.20],
        [10, 3.0, 1.43],

        [15, 0.5, 0.16],
        [15, 1.0, 0.32],
        [15, 1.5, 0.48],
        [15, 2.0, 0.63],
        [15, 2.5, 0.79],
        [15, 3.0, 0.95],

        [20, 0.5, 0.12],
        [20, 1.0, 0.24],
        [20, 1.5, 0.36],
        [20, 2.0, 0.48],
        [20, 2.5, 0.60],
        [20, 3.0, 0.72],

        [25, 0.5, 0.08],
        [25, 1.0, 0.16],
        [25, 1.5, 0.24],
        [25, 2.0, 0.32],
        [25, 2.5, 0.40],
        [25, 3.0, 0.48]
      ];


        /**
         * Run the database seeds.
         *
         * @return void
         */
        public function run()
        {

          foreach ($this->entries as $entry) {
              App\OzoneGiardiaInactivation::firstOrCreate([
                'temperature'=>$entry[0],
                'log_inactivation'=>$entry[1],
                'inactivation'=>$entry[2]
              ]);
          }

        }

}
