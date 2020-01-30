<?php

use Faker\Generator as Faker;

$factory->define(App\Consultation::class, function (Faker $faker) {
    return [
        'medecin_id' => rand(1,10),
        'talibe_id'	 => rand(1,10),
        'lieu'		 => str_random(10),
        'date'		 => $faker->date(),
        'avis'		 => $faker->paragraph(2,false)
    ];
});