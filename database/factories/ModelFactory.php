<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

    use Carbon\Carbon;
    use Faker\Generator;
    use Spatie\GoogleCalendar\Event;

    $factory->define(App\User::class, function (Faker\Generator $faker) {
        return [
            'name' => $faker->name,
            'email' => $faker->email,
        ];
    });

    $factory->define(Event::class, function (Generator $faker) {
        return [
            'name' => $faker->unique()->name,
            'startDateTime' => Carbon::now()->format('Y-m-d H:i:s'),
            'endDateTime' => Carbon::now()->format('Y-m-d H:i:s'),
        ];
    });
