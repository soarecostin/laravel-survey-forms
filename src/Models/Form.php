<?php

namespace SoareCostin\LaravelSurveyForms\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use SoareCostin\LaravelSurveyForms\Models\FormResponse;

class Form extends Model
{
    use SoftDeletes, Translatable;

    /**
     * Array with the fields translated in the Translation table.
     *
     * @var array
     */
    public $translatedAttributes = [
        'title', 'description'
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
        'name',
    ];

    public function items()
    {
        return $this->hasMany(FormItem::class, 'form_id')->orderBy('sort_order');
    }

    public function fieldItems()
    {
        return $this->hasMany(FormItem::class, 'form_id')
                    ->where('itemable_type', 'form_item_fields')
                    ->with(['itemable', 'itemable.values']);
    }

    public function fields()
    {
        if (!$this->fieldItems) {
            $this->load('fieldItems');
        }

        return $this->fieldItems->map(function ($item) {
            return $item->itemable;
        });
    }

    public function responses()
    {
        return $this->hasMany(FormResponse::class);
    }
}
