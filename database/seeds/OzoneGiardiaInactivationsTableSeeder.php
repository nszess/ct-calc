<?php

use Illuminate\Database\Seeder;

class OzoneGiardiaInactivationsTableSeeder extends Seeder
{

      private $entries = [
        [1, 1, 0.48],
        [1, 2, 0.97],
        [1, 3, 1.50],
        [1, 4, 1.90],
        [1, 5, 2.40],
        [1, 6, 2.90],

        [5, 1, 0.32],
        [5, 2, 0.63],
        [5, 3, 0.95],
        [5, 4, 1.30],
        [5, 5, 1.60],
        [5, 6, 1.90],

        [10, 1, 0.23],
        [10, 2, 0.48],
        [10, 3, 0.72],
        [10, 4, 0.95],
        [10, 5, 1.20],
        [10, 6, 1.43],

        [15, 1, 0.16],
        [15, 2, 0.32],
        [15, 3, 0.48],
        [15, 4, 0.63],
        [15, 5, 0.79],
        [15, 6, 0.95],

        [20, 1, 0.12],
        [20, 2, 0.24],
        [20, 3, 0.36],
        [20, 4, 0.48],
        [20, 5, 0.60],
        [20, 6, 0.72],

        [25, 1, 0.08],
        [25, 2, 0.16],
        [25, 3, 0.24],
        [25, 4, 0.32],
        [25, 5, 0.40],
        [25, 6, 0.48]
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
