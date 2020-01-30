<?php

use Illuminate\Database\Seeder;

class MedecinsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Medecin::class,10)->create();
    }
}
