<?php

use Faker\Generator as Faker;

$factory->define(App\Dieuw::class, function (Faker $faker) {
     
    $genre = $faker->boolean ;

    return [
        'daara_id'      => rand(1,20),
        'prenom'        => $faker->firstname,
        'nom'           => $faker->lastname,
        'genre'         => $genre,
        'pere'          => $faker->name('male'),
        'mere'          => $faker->name('female'),
        'datenaissance' => $faker->date(),
        'lieunaissance' => $faker->city,
        'adresse'       => $faker->address,
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
