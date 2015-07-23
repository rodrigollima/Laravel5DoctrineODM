<?php namespace Rlima\Laravel5DoctrineODM;

use Illuminate\Support\ServiceProvider;

class Laravel5DoctrineODMServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/doctrine.php' => config_path('doctrine.php'),
        ]);

        $this->publishes([
            __DIR__ . '/storage/' => storage_path(),
        ]);
  }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('Rlima\Laravel5DoctrineODM\ODM', function ($app) {
            try {
                return new LaravelDocumentManager($app['config']['doctrine']);
            } catch (\Exception $e ){
                throw new \Exception($e->getMessage());
            }
        });
    }
}
