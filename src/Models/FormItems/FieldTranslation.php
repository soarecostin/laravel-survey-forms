<?php

namespace SoareCostin\LaravelSurveyForms\Models\FormItems;

use Illuminate\Database\Eloquent\Model;

class FieldTranslation extends Model
{
    public $timestamps = false;

    protected $table = 'form_item_field_translations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'locale', 'label', 'description'
    ];
}
