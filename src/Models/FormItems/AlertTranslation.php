<?php

namespace SoareCostin\LaravelSurveyForms\Models\FormItems;

use Illuminate\Database\Eloquent\Model;

class AlertTranslation extends Model
{
    public $timestamps = false;

    protected $table = 'form_item_alert_translations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'locale', 'content'
    ];
}
