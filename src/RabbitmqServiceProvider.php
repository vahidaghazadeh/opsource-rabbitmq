<?php
namespace Opsource\Rabbitmq;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Foundation\Application;

class RabbitmqServiceProvider extends ServiceProvider
{
    public function boot(){
        $this->app->singleton(RabbitMQManager::class, function (Application $app) {
            return new RabbitMQManager($app);
        });

        // Create a substitute binding
        $this->app->bind('rabbitmq', function (Application $app) {
            return $app->make(RabbitMQManager::class);
        });

        $this->publishes([
            __DIR__ . '/config/rabbitmq.php' => config_path('rabbitmq.php'),
        ], 'config');
    }

    public function register()
    {
        return ['rabbitmq', RabbitMQManager::class];
    }
}
