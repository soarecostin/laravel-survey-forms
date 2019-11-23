<?php

namespace SoareCostin\LaravelSurveyForms\Models\FormItems;

use Illuminate\Database\Eloquent\Model;

class TitleTranslation extends Model
{
    public $timestamps = false;

    protected $table = 'form_item_title_translations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'locale', 'title', 'subtitle'
    ];
}
