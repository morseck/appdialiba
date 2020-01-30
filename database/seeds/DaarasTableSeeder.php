<?php

use Illuminate\Database\Seeder;

class DaarasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Daara::class,10)->create();
    }
}
