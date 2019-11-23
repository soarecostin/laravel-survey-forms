<?php

namespace SoareCostin\LaravelSurveyForms;

use Illuminate\Support\ServiceProvider;
use SoareCostin\LaravelSurveyForms\Models\FormItem;
use Illuminate\Database\Eloquent\Relations\Relation;
use SoareCostin\LaravelSurveyForms\Models\FormFieldValue;
use SoareCostin\LaravelSurveyForms\Observers\FormFieldValueObserver;
use SoareCostin\LaravelSurveyForms\Observers\FormItemObserver;

/**
 * Class LaravelSurveyFormsServiceProvider.
 */
class LaravelSurveyFormsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // $this->loadViewsFrom(__DIR__ . '/../resources/views', 'laravel-survey-forms');
        // $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'laravel-survey-forms');

        $this->registerObservers();
        $this->morphMap();

        if ($this->app->runningInConsole()) {
            $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
            $this->publishes([
                __DIR__ . '/../database/migrations' => database_path('migrations'),
            ], 'laravel-survey-forms-migrations');

            // $this->publishes([
            //     __DIR__ . '/../resources/views' => base_path('resources/views/vendor/laravel-survey-forms'),
            // ], 'laravel-survey-forms-views');

            // $this->publishes([
            //     __DIR__ . '/../resources/js/components' => base_path('resources/js/components/laravel-survey-forms'),
            // ], 'laravel-survey-forms-components');

            $this->publishes([
                __DIR__ . '/../config/laravel-survey-forms.php' => config_path('laravel-survey-forms.php'),
            ], 'laravel-survey-forms-config');
        }
    }

    public function register()
    {
        if (!$this->app->configurationIsCached()) {
            $this->mergeConfigFrom(__DIR__ . '/../config/laravel-survey-forms.php', 'laravel-survey-forms');
        }
    }

    /**
     * Register observers.
     *
     * @return void
     */
    protected function registerObservers()
    {
        FormItem::observe(FormItemObserver::class);
        FormFieldValue::observe(FormFieldValueObserver::class);
    }

    protected function morphMap()
    {
        Relation::morphMap([
            // Form Item type
            \SoareCostin\LaravelSurveyForms\Models\FormItems\Field::class,
            \SoareCostin\LaravelSurveyForms\Models\FormItems\Title::class,
            \SoareCostin\LaravelSurveyForms\Models\FormItems\Alert::class,
        ]);
    }
}
