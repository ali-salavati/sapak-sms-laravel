<?php

namespace Sapak\Sms\Laravel;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Sapak\Sms\SapakClient;

/**
 * SapakServiceProvider
 *
 * Registers the SapakClient in Laravel's service container.
 */
class SapakServiceProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     *
     * This method is for publishing configuration files.
     *
     * @return void
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            // This file should be published to the user's config directory
            $this->publishes([
                __DIR__ . '/../config/sapak.php' => $this->app->configPath('sapak.php'),
            ], 'config');
        }
    }

    /**
     * Register the service provider.
     *
     * This is where we bind our SapakClient into the container.
     *
     * @return void
     */
    public function register(): void
    {
        // Merge the user's config with the default package config
        $this->mergeConfigFrom(
            __DIR__ . '/../config/sapak.php',
            'sapak'
        );

        // Register the SapakClient as a singleton
        // This ensures the client is instantiated only once per request.
        $this->app->singleton(SapakClient::class, function (Application $app) {
            $config = $app['config'];

            $apiKey = $config->get('sapak.api_key');
            if (!$apiKey || !is_string($apiKey)) {
                throw new \InvalidArgumentException('Sapak API Key is not configured. Please publish the config or set SAPAK_API_KEY in your .env file.');
            }

            $guzzleConfig = $config->get('sapak.guzzle_config', []);

            // Instantiate the core client with the key and Guzzle options
            return new SapakClient(
                apiKey: $apiKey,
                guzzleConfig: $guzzleConfig
            );
        });

        // Create an alias 'sapak' for easier access (optional but good practice)
        $this->app->alias(SapakClient::class, 'sapak');
    }
}