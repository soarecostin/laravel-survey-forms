<?php

namespace SoareCostin\LaravelSurveyForms\Observers;

use SoareCostin\LaravelSurveyForms\Models\FormFieldValue;

class FormFieldValueObserver
{
    /**
     * Handle the form section "created" event.
     *
     * @param  \SoareCostin\LaravelSurveyForms\Models\FormFieldValue  $formFieldValue
     * @return void
     */
    public function creating(FormFieldValue $formFieldValue)
    {
        $formFieldValue->sort_order = $formFieldValue->nextSortIndex();
    }
}
