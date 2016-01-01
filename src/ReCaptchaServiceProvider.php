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
        $this->app->make('validator')->extendImplicit('recaptcha', 'Waavi\ReCaptcha\Validator@validate', 'ReCaptcha error');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('recaptcha.broker', function ($app) {
            return new IO\Broker($app['config']->get('recaptcha.url'), $app['config']->get('recaptcha.keys.secret'), $app['config']->get('recaptcha.timeout'));
        });
        $this->app->singleton('recaptcha', function ($app) {
            return new ReCaptcha($app['recaptcha.broker'], $app['config']->get('recaptcha.keys.site'));
        });
        $this->app->bind('Waavi\ReCaptcha\Validator', function ($app) {
            return new Validator($app['recaptcha']);
        });
    }
}
