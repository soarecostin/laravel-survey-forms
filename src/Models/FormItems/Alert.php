<?php

namespace SoareCostin\LaravelSurveyForms\Models\FormItems;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use SoareCostin\LaravelSurveyForms\Models\FormItems\FormItemContract;

class Alert extends Model implements FormItemContract
{
    use SoftDeletes, Translatable;

    protected $table = 'form_item_alert';

    /**
     * Array with the fields translated in the Translation table.
     *
     * @var array
     */
    public $translatedAttributes = [
        'content'
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['translations'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'variant'
    ];

    public function item()
    {
        return $this->morphOne(FormItem::class, 'itemable');
    }
}
