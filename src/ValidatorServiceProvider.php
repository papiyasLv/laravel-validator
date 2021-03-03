<?php


namespace Papiyas\Validator;

use Illuminate\Support\ServiceProvider;

class ValidatorServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../resources/lang'  => resource_path('lang'),
        ]);
    }

    public function register()
    {
        $this->app->singleton('papiyas_validator', function ($app) {
            $validator = new Factory($app['translator'], $app);

            // The validation presence verifier is responsible for determining the existence of
            // values in a given data collection which is typically a relational database or
            // other persistent data stores. It is used to check for "uniqueness" as well.
            if (isset($app['db'], $app['validation.presence'])) {
                $validator->setPresenceVerifier($app['validation.presence']);
            }

            return $validator;
        });

        $this->app->singleton('message', Message::class);
    }
}
