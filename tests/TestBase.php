<?php

namespace SoareCostin\LaravelSurveyForms\Tests;

use Orchestra\Testbench\TestCase;
use SoareCostin\LaravelSurveyForms\Models\Form;
use SoareCostin\LaravelSurveyForms\Models\FormItem;
use SoareCostin\LaravelSurveyForms\Models\FormFieldValue;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use SoareCostin\LaravelSurveyForms\LaravelSurveyFormsServiceProvider;
use SoareCostin\LaravelSurveyForms\Models\FormAnswer;
use SoareCostin\LaravelSurveyForms\Models\FormResponse;

abstract class TestBase extends TestCase
{
    use DatabaseMigrations;

    protected function getPackageProviders($app)
    {
        return [
            LaravelSurveyFormsServiceProvider::class
        ];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // Setup translatable config
        $app['config']->set('translatable.locales', ['en']);
        $app['config']->set('translatable.locale_separator', '-');
        $app['config']->set('translatable.locale', null);
    }

    protected function setUp(): void
    {
        parent::setUp();

        // Register model factories
        $this->withFactories(__DIR__ . '/factories');

        $this->migrate();
    }

    protected function migrate()
    {
        // Run test-specific migrations
        $this->loadMigrationsFrom([
            '--path' => realpath(__DIR__ . '/migrations'),
        ]);
    }

    protected function createForm($numberOfItems = 10)
    {
        // Create a form
        $form = factory(Form::class)->create();

        // Create form items
        factory(FormItem::class, $numberOfItems)->create([
            'form_id' => $form->id
        ]);

        // Add values for Radio and Checkboxes
        $form->fields()->filter(function ($field) {
            return $field->values_allowed;
        })->each(function ($field) {
            $field->values()->saveMany(
                factory(FormFieldValue::class, 5)->make()
            );
            $field->load('values');
        });

        return $form;
    }

    protected function fillForm($form, $numberOfResponses = 1)
    {
        factory(FormResponse::class, $numberOfResponses)->create([
            'form_id' => $form->id
        ])->each(function ($formResponse) use ($form) {
            $form->fields()->each(function ($field) use ($formResponse) {
                $fieldAttributes = [
                    'form_response_id' => $formResponse->id,
                    'field_id' => $field->id,
                    'field_name' => $field->field_name,
                ];
                if ($field->type == 'radio') {
                    $fieldAttributes['value'] = $field->values->random()->name;
                }
                if ($field->type == 'checkboxes') {
                    $fieldAttributes['value'] = $field->values->random(mt_rand(1, $field->values->count()))->pluck('name');
                }

                factory(FormAnswer::class)->create($fieldAttributes);
            });
        });
    }

    /* deprecated */
    // protected function createEventRSVP()
    // {
    //     // Create a form
    //     $form = factory(Form::class)->create([
    //         'name' => 'Event RSVP',
    //         'title' => 'Event RSVP',
    //     ]);

    //     $canYouAttendField = factory(Field::class)->create([
    //         'type' => 'radio',
    //         'field_name' => 'can_you_attend',
    //         'label' => 'Can you attend?',
    //     ]);

    //     factory(FormItem::class)->create([
    //         'form_id' => $form->id,
    //         'itemable_id' => $canYouAttendField->id,
    //         'itemable_type' => collect(Relation::morphMap())
    //                             ->flip()
    //                             ->get(get_class($canYouAttendField)),
    //     ]);

    //     $canYouAttendField->values()->saveMany([
    //         factory(FormFieldValue::class)->make([
    //             'name' => 'yes',
    //             'label' => 'yes'
    //         ]),
    //         factory(FormFieldValue::class)->make([
    //             'name' => 'no',
    //             'label' => 'no'
    //         ]),
    //     ]);

    //     return $form;
    // }

}
