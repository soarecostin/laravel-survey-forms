<?php

namespace SoareCostin\LaravelSurveyForms\Models\FormItems;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Title extends Model implements FormItemContract
{
    use SoftDeletes, Translatable;

    protected $table = 'form_item_title';

    /**
     * Array with the fields translated in the Translation table.
     *
     * @var array
     */
    public $translatedAttributes = [
        'title', 'subtitle'
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['translations'];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function item()
    {
        return $this->morphOne(FormItem::class, 'itemable');
    }
}
