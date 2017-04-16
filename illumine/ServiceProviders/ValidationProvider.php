<?php namespace IllumineFramework\ServiceProviders;

use Illuminate\Support\ServiceProvider;
use Illuminate\Translation\FileLoader;
use Illuminate\Translation\Translator;
use Illuminate\Validation\Factory;
use Illuminate\Validation\DatabasePresenceVerifier;

class ValidationProvider extends ServiceProvider{

    /**
     * Register the service provider.
     * @return void
     */
    public function register()
    {
        $this->app->singleton('translator', function() {
            $fileLoader = new FileLoader($this->app['files'], 'lang');
            $translator = new Translator($fileLoader, $this->app['config']->get('locale'));
            return $translator;
        });
        $this->app->singleton('validator', function() {
            $presence = new DatabasePresenceVerifier($this->app['db']);
            $validator = new Factory($this->app['translator'], $this->app);
            $validator->setPresenceVerifier($presence);
            return $validator;
        });
    }
}