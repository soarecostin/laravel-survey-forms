<?php

namespace SoareCostin\LaravelSurveyForms\Models\FormItems;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use SoareCostin\LaravelSurveyForms\Models\FormItem;
use SoareCostin\LaravelSurveyForms\Models\FormFieldValue;

class Field extends Model implements FormItemContract
{
    use SoftDeletes, Translatable;

    protected $table = 'form_item_fields';

    /**
     * Array with the fields translated in the Translation table.
     *
     * @var array
     */
    public $translatedAttributes = ['label', 'description'];

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
    protected $fillable = ['type', 'field_name', 'required'];

    public function item()
    {
        return $this->morphOne(FormItem::class, 'itemable');
    }

    public function values()
    {
        return $this->hasMany(FormFieldValue::class, 'field_id')->orderBy('sort_order');
    }

    public function getValuesAllowedAttribute()
    {
        return in_array($this->type, ['radio', 'checkboxes']);
    }
}
