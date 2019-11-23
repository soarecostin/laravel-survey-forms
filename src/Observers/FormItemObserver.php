<?php

namespace SoareCostin\LaravelSurveyForms\Observers;

use SoareCostin\LaravelSurveyForms\Models\FormItem;

class FormItemObserver
{
    /**
     * Handle the form section "created" event.
     *
     * @param  \SoareCostin\LaravelSurveyForms\Models\FormItem  $formItem
     * @return void
     */
    public function creating(FormItem $formItem)
    {
        $formItem->sort_order = $formItem->nextSortIndex();
    }
}
