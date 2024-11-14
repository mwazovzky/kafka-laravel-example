<?php

namespace App\Providers;

use App\Serializers\SerializerBuilder;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Junges\Kafka\Contracts\MessageProducer;
use Junges\Kafka\Producers\Builder as KafkaProducerBuilder;

class KafkaServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->when(SerializerBuilder::class)
            ->needs(ClientInterface::class)
            ->give(function () {
                return new Client([
                    'base_uri' => config('kafka.schema_registry.host'),
                    'auth' => [
                        config('kafka.schema_registry.username'),
                        config('kafka.schema_registry.password'),
                    ],
                ]);
            });

        $this->app->bind(MessageProducer::class, function () {
            return KafkaProducerBuilder::create(
                broker: config('kafka.brokers'),
            )->withSasl(
                username: config('kafka.sasl.username'),
                password: config('kafka.sasl.password'),
                mechanisms: config('kafka.sasl.mechanisms'),
                securityProtocol: config('kafka.securityProtocol'),
            );
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Vite::prefetch(concurrency: 3);
    }
}
