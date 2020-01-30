<?php

use Faker\Generator as Faker;

$factory->define(App\Daara::class, function (Faker $faker) {
    return [
        'nom'		 	=> 'Daara '.substr( (str_shuffle('abcdefghijklmnopqrstuvwxyz')), 0, 9 ),
        'lat'          	=> $faker->latitude,
        'lon'   	 	=> $faker->longitude,
        'creation'      => '2005-04-14',
        'dieuw'     	=> $faker->name,
        'phone'			=> $faker->phoneNumber,
        'image'			=> '1.jpg'
    ];
});
