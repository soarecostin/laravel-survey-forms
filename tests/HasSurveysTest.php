<?php

namespace SoareCostin\LaravelSurveyForms\Tests;

use SoareCostin\LaravelSurveyForms\Models\FormResponse;
use SoareCostin\LaravelSurveyForms\Tests\Models\User;
use SoareCostin\LaravelSurveyForms\Tests\Models\Event;

class HasSurveysTest extends TestBase
{
    protected $form;
    protected $numberOfItems = 30;
    protected $numberOfResponses = 5;

    protected function setUp(): void
    {
        parent::setUp();

        $this->form = $this->createForm($this->numberOfItems);

        $this->fillForm($this->form, $this->numberOfResponses);
    }

    /** @test */
    public function form_responses_were_created()
    {
        $this->assertGreaterThan(0, Event::count());
        $this->assertGreaterThan(0, User::count());

        // EventUser many-to-many
        $this->assertGreaterThan(0, User::find(1)->events()->count());

        $this->assertEquals($this->numberOfResponses, FormResponse::count());
    }

    /** @test */
    public function form_response_contains_answers()
    {
        $this->assertEquals(
            $this->form->fieldItems()->count(), // number of fields in the form
            $this->form->responses()->first()->answers()->count() // number of answers in the first response
        );
    }

    /** @test */
    public function form_response_is_available_to_the_formable_object()
    {
        $eventUser = User::find(1)->events[0]->pivot;

        $this->assertGreaterThan(0, $eventUser->formResponse->answers()->count());

        $this->assertNotNull(
            $eventUser->formResponse->answers[0]->value
        );
    }

    /** @test */
    public function test_form_response_radio_field_answer_value_is_valid()
    {
        $eventUser = User::find(1)->events[0]->pivot;

        // Radio
        $firstRadioField = $this->form->fields()->first(function ($field) {
            return $field->type == 'radio';
        });

        if ($firstRadioField) {
            $answer = $eventUser->formResponse->answers->first(function ($answer) use ($firstRadioField) {
                return $answer['field_id'] == $firstRadioField->id;
            });

            $this->assertContains(
                $answer->value,
                $firstRadioField->values->pluck('name')
            );
        }
    }

    /** @test */
    public function test_form_response_checkboxes_field_answer_value_is_valid()
    {
        $eventUser = User::find(1)->events[0]->pivot;

        // Checkbox
        $firstCheckboxesField = $this->form->fields()->first(function ($field) {
            return $field->type == 'checkboxes';
        });

        if ($firstCheckboxesField) {
            $answer = $eventUser->formResponse->answers->first(function ($answer) use ($firstCheckboxesField) {
                return $answer['field_id'] == $firstCheckboxesField->id;
            });

            $intersect = $firstCheckboxesField->values->pluck('name')->intersect(collect($answer->value))->values();
            $this->assertEquals(
                $answer->value,
                $intersect->all()
            );
        }
    }
}
