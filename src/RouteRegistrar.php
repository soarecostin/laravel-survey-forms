<?php

namespace SoareCostin\LaravelSurveyForms;

use Illuminate\Support\Facades\Route;

class RouteRegistrar
{
    protected $routePrefix;

    public function __construct($routePrefix = '')
    {
        $this->routePrefix = $routePrefix;
    }

    /**
     * Register routes for transient tokens, clients, and personal access tokens.
     *
     * @return void
     */
    public function all()
    {
        $this->forms();
        $this->formItems();
        $this->formItemsSaveOrder();
    }

    protected function routeName($name)
    {
        return $this->routePrefix
            ? $this->routePrefix . '.' . $name
            : $name;
    }

    /**
     * Register the main routes needed for forms
     *
     * @return void
     */
    public function forms()
    {
        Route::get('/forms/draw', 'FormsController@draw')->name($this->routeName('forms.draw'));
        Route::resource('forms', 'FormsController')->except(['show'])->names([
            'index' => $this->routeName('forms.index'),
            'create' => $this->routeName('forms.create'),
            'store' => $this->routeName('forms.store'),
            'edit' => $this->routeName('forms.edit'),
            'update' => $this->routeName('forms.update'),
            'destroy' => $this->routeName('forms.destroy')
        ]);
    }

    /**
     * Register the main routes needed for pages
     *
     * @return void
     */
    public function formItems()
    {
        Route::get('/forms/{form}/items/draw', 'FormItemsController@draw')->name($this->routeName('forms.items.draw'));

        Route::get('/forms/{form}/items', 'FormItemsController@index')->name($this->routeName('forms.items.index'));
        Route::get('/forms/{form}/items/create', 'FormItemsController@create')->name($this->routeName('forms.items.create'));
        Route::post('forms/{form}/items', 'FormItemsController@store')->name($this->routeName('forms.items.store'));
        Route::get('/forms/items/{formItem}/edit', 'FormItemsController@edit')->name($this->routeName('forms.items.edit'));
        Route::put('/forms/items/{formItem}', 'FormItemsController@update')->name($this->routeName('forms.items.update'));
        Route::delete('/forms/items/{formItem}', 'FormItemsController@destroy')->name($this->routeName('forms.items.destroy'));
    }

    /**
     * Register the extra routes needed for forms
     *
     * @return void
     */
    public function formItemsSaveOrder()
    {
        Route::post('/forms/{form}/items/save-order', 'FormItemsOrderSaveController')
            ->name($this->routeName('forms.items.save-order'));
    }
}
