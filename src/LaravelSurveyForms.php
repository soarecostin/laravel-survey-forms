<?php

namespace SoareCostin\LaravelSurveyForms;

use Illuminate\Support\Facades\Route;

class LaravelSurveyForms
{
    /**
     * Binds the package routes into the controller.
     *
     * @param  array  $options
     * @return void
     */
    public static function routes(string $type = '', array $options = [], string $routePrefix = '')
    {
        $defaultOptions = [
            'namespace' => '\SoareCostin\LaravelSurveyForms\Http\Controllers',
            'middleware' => 'bindings'
        ];
        $options = array_merge($defaultOptions, $options);
        Route::group($options, function () use ($type, $routePrefix) {
            $routeRegistrar = new RouteRegistrar($routePrefix);
            if ($type == 'forms') {
                $routeRegistrar->forms();
            }
            if ($type == 'form-items') {
                $routeRegistrar->formItems();
            }
            if ($type == 'form-items-save-order') {
                $routeRegistrar->formItemsSaveOrder();
            }
            if ($type == '') {
                $routeRegistrar->all();
            }
        });
    }
}
