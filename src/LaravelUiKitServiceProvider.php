<?php

namespace LaravelUiKit;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class LaravelUiKitServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/ui-kit.php', 'ui-kit');
    }

    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /*
         * Optional methods to load your package assets
         */
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'laravel-ui-kit');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'laravel-ui-kit');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/ui-kit.php' => config_path('ui-kit.php'),
                __DIR__.'/../config/ui-kit' => config_path('ui-kit'),
            ], 'config');

            // Publishing the views.
            $this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/ui-kit'),
            ], 'views');
        }

        $this->bootResources();
        $this->bootBladeComponents();
        $this->bootStrMacros();
    }

    protected function bootBladeComponents()
    {
        $components = config('ui-kit.components', []);

        foreach ($components as $alias => $options) {
            $view = is_array($options) ? $options['view'] : $options;

            Blade::component('ui-kit::' . $view, $alias);
        }
    }

    protected function bootResources()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'ui-kit');
    }

    protected function bootStrMacros()
    {
        Str::macro('prefixClasses', function (string $prefix, ?string $classes) {
            if (!$classes) {
                return '';
            }

            // clear double+ spaces
            $classes = trim(preg_replace('/\s+/', ' ', $classes));
            if ($classes === '') {
                return '';
            }

            // convert to array
            $classes = explode(' ', $classes);
            // add prefix to each class
            $classes = array_map(function ($class) use ($prefix) {
                return $prefix . $class;
            }, $classes);
            // convert to string
            return implode(' ', $classes);
        });

        Str::macro('mergeClasses', function (...$classes) {
            $classes = implode(' ', Arr::flatten($classes));
            $classes = trim(preg_replace('/\s+/', ' ', $classes));
            $classes = implode(' ', array_unique(explode(' ', $classes)));

            return $classes;
        });
    }
}
