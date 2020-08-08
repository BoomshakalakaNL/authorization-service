<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Role;
use App\Activity;
use App\Permission;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Permission::class, function (Faker $faker) {
    return [
        'name' => $faker->domainWord
    ];
});

$factory->define(Role::class, function (Faker $faker) {
    return [
        'name' => $faker->jobTitle
    ];
});


$factory->define(Activity::class, function (Faker $faker) {
    return [
        'url' => $faker->url,
        'url_regex' => $faker->randomElement(array(
            '[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}', // uuid
            '[a-fA-F0-9]', // hexadecimal 
            '[0-9]', // decimal
            '[a-zA-Z]' // alphbet no spaces
        )),
        'method' =>  $faker->randomElement(array ('POST', 'GET', 'PUT', 'DELETE', 'PATCH'))
    ];
});


