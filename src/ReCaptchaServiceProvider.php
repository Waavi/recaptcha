<?php

namespace Waavi\ReCaptcha;

use Illuminate\Support\ServiceProvider;

class ReCaptchaServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__ . '/../lang', 'recaptcha');
        $this->loadViewsFrom(__DIR__ . '/../views', 'recaptcha');
        $this->publishes([
            __DIR__ . '/../config/recaptcha.php' => config_path('recaptcha.php'),
            __DIR__ . '/../views'                => base_path('resources/views/vendor/recaptcha'),
            __DIR__ . '/../lang'                 => base_path('resources/lang/vendor/recaptcha'),
        ]);
        $this->mergeConfigFrom(
            __DIR__ . '/../config/recaptcha.php', 'recaptcha'
        );
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {

    }

}
