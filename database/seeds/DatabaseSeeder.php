<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
        			// UsersTableSeeder::class,
        			 //DaarasTableSeeder::class,
        			// DieuwsTableSeeder::class,
        			 //MedecinsTableSeeder::class,
        			 //TalibesTableSeeder::class,
                     //ConsultationsTableSeeder::class,
                    //RolesAndPermissionsSeeder::class,
                    NotificationTypesSeeder::class

        	]);


    }
}
