<?php

use Faker\Generator as Faker;

$factory->define(App\Talibe::class, function (Faker $faker) {
    
    $genre = $faker->boolean ;

    return [
        'daara_id'      => rand(1,15),
        'dieuw_id'      => rand(1,15),
        'niveau'        => rand(1,60),
        'prenom'        => $faker->firstname,
        'nom'           => $faker->lastname,
        'genre'         => $genre,
        'pere'          => $faker->name('male'),
        'mere'          => $faker->name('female'),
        'datenaissance' => $faker->date(),
        'lieunaissance' => $faker->city,
        'adresse'       => $faker->address,
        'region'        => str_random(12),
        'tuteur'        => $faker->name,
        'phone1'        => $faker->phoneNumber,
        'phone2'        => $faker->phoneNumber,
        'arrivee'       => $faker->date(),
        'commentaire'   => $faker->paragraph,
        'avatar'        => function () use ($genre){

            return ($genre == true) ? 'user_male.ico':'user_female.ico';
        }

    ];
});