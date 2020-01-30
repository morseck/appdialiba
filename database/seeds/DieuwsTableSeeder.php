<?php

use Illuminate\Database\Seeder;

class DieuwsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Dieuw::class,10)->create();
    }
}
