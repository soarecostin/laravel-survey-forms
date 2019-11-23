<?php

namespace SoareCostin\LaravelSurveyForms\Tests;

use SoareCostin\LaravelSurveyForms\Models\Form;
use SoareCostin\LaravelSurveyForms\Models\FormItem;

class FormTest extends TestBase
{
    protected $form;
    protected $numberOfItems = 20;

    public function setUp() : void
    {
        parent::setUp();

        $this->form = $this->createForm($this->numberOfItems);
    }

    /** @test */
    public function can_create_a_form()
    {
        $form = factory(Form::class)->create();

        $this->assertNotNull($form);
        $this->assertDatabaseHas('forms', [
            'name' => $form->name
        ]);
    }

    /** @test */
    public function a_form_has_items()
    {
        $this->assertCount($this->numberOfItems, $this->form->items);
    }

    /** @test */
    public function a_form_item_of_type_radio_or_checkbox_has_values()
    {
        $firstItemOfTypeRadioOrCheckbox = $this->form->fields()->first(function ($field) {
            return $field->values_allowed;
        });

        // if (!$firstItemOfTypeRadioOrCheckbox) {
        //     // create it
        //     $field = factory(Field::class)->create([
        //         'type' => 'radio'
        //     ]);
        //     $firstItemOfTypeRadioOrCheckbox = factory(FormItem::class)->states('field')->create([
        //         'form_id' => $this->form->id,
        //         'itemable_id' => $field->id
        //     ]);
        // }

        $this->assertGreaterThan(0, $firstItemOfTypeRadioOrCheckbox->values->count());
    }

    /** @test */
    public function a_form_has_form_items()
    {
        $form = factory(Form::class)->create();

        // Create a new form item
        factory(FormItem::class)->states('field')->create([
            'form_id' => $form->id
        ]);

        $this->assertCount(1, $form->fieldItems);
    }

    /** @test */
    public function can_change_form_items_sort_order()
    {
        // First item in the collection has the sort_order = 1
        $this->assertEquals(1, $this->form->items[0]->sort_order);

        // Manually change the first item's sort_order
        $this->form->items[0]->sort_order = 50;
        $this->form->items[0]->save();

        // Reload items
        $this->form->load('items');

        // First item in collection is the one with the sort_order = 2
        $this->assertEquals(2, $this->form->items[0]->sort_order);
    }

    /** @test */
    public function add_a_new_form_item_triggers_the_observer()
    {
        // Test to see if the sort_order field was auto-populated by the Observer
        $this->assertNotNull($this->form->items[0]->sort_order);
        $this->assertNotNull($this->form->items[1]->sort_order);

        // Create a new form item
        factory(FormItem::class)->create([
            'form_id' => $this->form->id
        ]);

        // Reload items
        $this->form->load('items');

        $formItemsNo = $this->form->items->count();
        $this->assertEquals(
            $formItemsNo,
            $this->form->items[$formItemsNo-1]->sort_order
        );
    }
}