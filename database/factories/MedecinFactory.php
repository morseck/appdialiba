<?php

use Faker\Generator as Faker;

$factory->define(App\Medecin::class, function (Faker $faker) {
    return [
        'prenom'    => $faker->firstname,
        'nom'       => $faker->lastname,
        'email'     => $faker->safeEmail,
        'spec'      => substr(str_shuffle('abcdefghijklmnopqrstuvwxyz'),0,12),
        'phone'     => $faker->phoneNumber,
        'email'     => $faker->safeEmail,
        'hopital'   => str_random(12)

    ];
});
