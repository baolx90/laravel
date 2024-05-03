<?php

namespace Kizi\Shopify;

use Illuminate\Routing\Redirector;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

/**
 * This package's provider for Laravel.
 */
class ShopifyAppProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // $this->bootRoutes();
        // $this->bootViews();
        // $this->bootConfig();
        // $this->bootDatabase();
        // $this->bootJobs();
        // $this->bootObservers();
        // $this->bootMiddlewares();
        // $this->bootMacros();
        // $this->bootDirectives();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Boot the routes for the package.
     *
     * @return void
     */
    private function bootRoutes(): void
    {
        $this->loadRoutesFrom(__DIR__.'/resources/routes/api.php');
        $this->loadRoutesFrom(__DIR__.'/resources/routes/shopify.php');
    }

    /**
     * Boot the views for the package.
     *
     * @return void
     */
    private function bootViews(): void
    {
        $viewResourcesPath = __DIR__.'/resources/views';

        $this->loadViewsFrom($viewResourcesPath, 'shopify-app');

        $this->publishes([
            $viewResourcesPath => resource_path('views/vendor/shopify-app'),
        ], 'shopify-views');
    }

    /**
     * Boot the config for the package.
     *
     * @return void
     */
    private function bootConfig(): void
    {
        $this->publishes([
            __DIR__.'/resources/config/shopify-app.php' => "{$this->app->configPath()}/shopify-app.php",
        ], 'shopify-config');
    }

    /**
     * Boot the database for the package.
     *
     * @return void
     */
    private function bootDatabase(): void
    {
        $databaseMigrationsPath = __DIR__.'/resources/database/migrations';

        if ($this->app['config']->get('shopify-app.manual_migrations')) {
            $this->publishes([
                $databaseMigrationsPath => "{$this->app->databasePath()}/migrations",
            ], 'shopify-migrations');
        } else {
            $this->loadMigrationsFrom($databaseMigrationsPath);
        }
    }

    /**
     * Boot the jobs for the package.
     *
     * @return void
     */
    private function bootJobs(): void
    {
        $this->publishes([
            __DIR__.'/resources/jobs/AppUninstalledJob.php' => "{$this->app->path()}/Jobs/AppUninstalledJob.php",
        ], 'shopify-jobs');
    }

    /**
     * Boot the observers for the package.
     *
     * @return void
     */
    private function bootObservers(): void
    {
        $model = Util::getShopifyConfig('user_model');
        $model::observe($this->app->make(ShopObserver::class));
    }

    /**
     * Boot the middlewares for the package.
     *
     * @return void
     */
    private function bootMiddlewares(): void
    {
        $this->app['router']->aliasMiddleware('auth.proxy', AuthProxy::class);
        $this->app['router']->aliasMiddleware('auth.webhook', AuthWebhook::class);
        $this->app['router']->aliasMiddleware('billable', Billable::class);
        $this->app['router']->aliasMiddleware('verify.shopify', VerifyShopify::class);

        $this->app['router']->pushMiddlewareToGroup('web', IframeProtection::class);
    }

    /**
     * Apply macros to Laravel framework.
     *
     * @return void
     */
    private function bootMacros(): void
    {
        Redirector::macro('tokenRedirect', new TokenRedirect());
        UrlGenerator::macro('tokenRoute', new TokenRoute());
    }

    /**
     * Init Blade directives.
     *
     * @return void
     */
    private function bootDirectives(): void
    {
        Blade::directive('sessionToken', new SessionToken());
    }
}