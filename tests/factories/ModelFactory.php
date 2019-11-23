<?php

use Illuminate\Support\Str;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Relations\Relation;

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

/** @var \Illuminate\Database\Eloquent\Factory $factory */

$factory->define(\SoareCostin\LaravelSurveyForms\Models\Form::class, function (Faker $faker) {
    return [
        'name' => $faker->title,
        'title' => $faker->title,
        'description' => $faker->sentence,
    ];
});

$factory->define(\SoareCostin\LaravelSurveyForms\Models\FormItem::class, function (Faker $faker) {
    $itemables = [
        \SoareCostin\LaravelSurveyForms\Models\FormItems\Field::class,
        \SoareCostin\LaravelSurveyForms\Models\FormItems\Alert::class,
        \SoareCostin\LaravelSurveyForms\Models\FormItems\Title::class,
    ];
    $itemableType = $faker->randomElement($itemables);
    $itemable = factory($itemableType)->create();

    $map = collect(Relation::morphMap())->flip();

    return [
        'form_id' => function () {
            return factory(\SoareCostin\LaravelSurveyForms\Models\Form::class)->create()->id;
        },
        'itemable_id' => $itemable->id,
        'itemable_type' => $map->get($itemableType, $itemableType),
        'published' => 1,
    ];
});

$factory->state(\SoareCostin\LaravelSurveyForms\Models\FormItem::class, 'field', function () {
    return [
        'itemable_id' => function () {
            return factory(\SoareCostin\LaravelSurveyForms\Models\FormItems\Field::class)->create()->id;
        },
        'itemable_type' => 'form_item_fields'
    ];
});

$factory->state(\SoareCostin\LaravelSurveyForms\Models\FormItem::class, 'title', function () {
    return [
        'itemable_id' => function () {
            return factory(\SoareCostin\LaravelSurveyForms\Models\FormItems\Title::class)->create()->id;
        },
        'itemable_type' => 'form_item_title'
    ];
});

$factory->state(\SoareCostin\LaravelSurveyForms\Models\FormItem::class, 'alert', function () {
    return [
        'itemable_id' => function () {
            return factory(\SoareCostin\LaravelSurveyForms\Models\FormItems\Alert::class)->create()->id;
        },
        'itemable_type' => 'form_item_alert'
    ];
});

$factory->define(\SoareCostin\LaravelSurveyForms\Models\FormItems\Field::class, function (Faker $faker) {
    return [
        'type' => $faker->randomElement(['radio', 'checkboxes', 'input']),
        'field_name' => implode("_", $faker->words(2)),
        'required' => $faker->boolean,
        'label' => $faker->sentence(3),
        'description' => $faker->sentence
    ];
});

$factory->define(\SoareCostin\LaravelSurveyForms\Models\FormItems\Title::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(3),
        'subtitle' => $faker->sentence
    ];
});

$factory->define(\SoareCostin\LaravelSurveyForms\Models\FormItems\Alert::class, function (Faker $faker) {
    return [
        'content' => $faker->sentence
    ];
});

$factory->define(\SoareCostin\LaravelSurveyForms\Models\FormFieldValue::class, function (Faker $faker) {
    return [
        'field_id' => function () use ($faker) {
            return factory(\SoareCostin\LaravelSurveyForms\Models\FormItems\Field::class)->create([
                'type' => $faker->randomElement(['radio', 'checkboxes']),
            ])->id;
        },
        'name' => strtolower($faker->unique()->word),
        'label' => $faker->sentence(3)
    ];
});

$factory->define(\SoareCostin\LaravelSurveyForms\Models\FormResponse::class, function (Faker $faker) {
    $formable = factory(\SoareCostin\LaravelSurveyForms\Tests\Models\EventUser::class)->create();

    return [
        'form_id' => function () {
            return factory(\SoareCostin\LaravelSurveyForms\Models\Form::class)->create()->id;
        },
        'formable_id' => $formable->id,
        'formable_type' => 'SoareCostin\LaravelSurveyForms\Tests\Models\EventUser'
    ];
});

$factory->define(\SoareCostin\LaravelSurveyForms\Models\FormAnswer::class, function (Faker $faker) {

    $inputField = factory(\SoareCostin\LaravelSurveyForms\Models\FormItems\Field::class)->create([
        'type' => 'input'
    ]);

    return [
        'form_response_id' => function () {
            return factory(\SoareCostin\LaravelSurveyForms\Models\FormResponse::class)->create()->id;
        },
        'field_id' => $inputField->id,
        'field_name' => $inputField->name,
        'value' => $faker->word
    ];
});

$factory->define(\SoareCostin\LaravelSurveyForms\Tests\Models\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
    ];
});

$factory->define(\SoareCostin\LaravelSurveyForms\Tests\Models\Event::class, function (Faker $faker) {
    return [
        'name' => $faker->city,
        'venue' => $faker->company,
        'address' => $faker->address,
    ];
});

$factory->define(\SoareCostin\LaravelSurveyForms\Tests\Models\EventUser::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(\SoareCostin\LaravelSurveyForms\Tests\Models\User::class)->create()->id;
        },
        'event_id' => function () {
            return factory(\SoareCostin\LaravelSurveyForms\Tests\Models\Event::class)->create()->id;
        },
    ];
});