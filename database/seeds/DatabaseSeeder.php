<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ChloramineGiardiaInactivationsTableSeeder::class);
        $this->call(ChloramineVirusInactivationsTableSeeder::class);

        $this->call(ChlorineDioxideGiardiaInactivationsTableSeeder::class);
        $this->call(ChlorineDioxideVirusInactivationsTableSeeder::class);

        //$this->call(ChlorineDioxideGiardiaInactivationsTableSeeder::class);
        //$this->call(ChlorineDioxideVirusInactivationsTableSeeder::class);

        $this->call(OzoneGiardiaInactivationsTableSeeder::class);
        $this->call(OzoneVirusInactivationsTableSeeder::class);
    }
}
