<?php namespace IllumineFramework\ServiceProviders;

use Illuminate\Support\ServiceProvider;
use Illuminate\View\Engines\EngineResolver;
use Illuminate\View\Compilers\BladeCompiler;
use Illuminate\View\Engines\CompilerEngine;
use Illuminate\View\Engines\PhpEngine;
use Illuminate\View\FileViewFinder;
use Illuminate\Events\Dispatcher;
use Illuminate\View\Factory;

class ViewFactoryProvider extends ServiceProvider{

    /**
     * Register the service provider.
     * @return void
     */
    public function register()
    {
        $viewResolver = new EngineResolver;
        $viewResolver->register('php', function () {
            return new PhpEngine;
        });
        $viewResolver->register('blade', function () {
            $blade = new BladeCompiler($this->app['files'], $this->app['config']->get('cache.stores.files')['path'].'/../views');
            return new CompilerEngine($blade, $this->app['files']);
        });
        $this->app->singleton('view', function () use ($viewResolver) {
            $viewFactory = new Factory($viewResolver, new FileViewFinder($this->app['files'], [$this->app['config']->get('paths.views')]), new Dispatcher($this->app));
            return $viewFactory;
        });

    }

}