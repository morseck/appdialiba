<?php

use Illuminate\Database\Seeder;

class TalibesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Talibe::class,90)->create();
    }
}
