<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' =>  $faker->word(),
        'slug' => $faker->slug(),
        'is_active' => $faker->boolean(),
        'description' => $faker->text(),
        'short_description' => $faker->text(),
        'price' => $faker->numberBetween(10,9808),
        'manage_stock' => false,
        'in_stock' => $faker->boolean(),
        'sku' => $faker->word(),
    ];
});
