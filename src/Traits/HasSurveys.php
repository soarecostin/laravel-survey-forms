<?php

namespace SoareCostin\LaravelSurveyForms\Traits;

use SoareCostin\LaravelSurveyForms\Models\FormResponse;

/**
 * @mixin \Illuminate\Database\Eloquent\Model
 */
trait HasSurveys
{
    public function formResponses()
    {
        return $this->morphMany(FormResponse::class, 'formable');
    }

    public function formResponse()
    {
        return $this->morphOne(FormResponse::class, 'formable');
    }
}