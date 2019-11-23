<?php

namespace SoareCostin\LaravelSurveyForms\Models;

use Illuminate\Database\Eloquent\Model;

class FormFieldValueTranslation extends Model
{
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'locale', 'label'
    ];
}
