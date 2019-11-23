<?php

namespace SoareCostin\LaravelSurveyForms\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use SoareCostin\LaravelSurveyForms\Models\FormItems\Field;

class FormFieldValue extends Model
{
    use SoftDeletes, Translatable;

    /**
     * Array with the fields translated in the Translation table.
     *
     * @var array
     */
    public $translatedAttributes = ['label'];

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
        'name', 'sort_order'
    ];

    public function field()
    {
        return $this->belongsTo(Field::class, 'field_id');
    }

    public function nextSortIndex()
    {
        if (!$maxSortOrder = self::where('field_id', $this->field_id)->max('sort_order')) {
            return 1;
        }

        return $maxSortOrder + 1;
    }
}
