<?php namespace Aedart\Config\Loader\Providers;

use Aedart\Config\Loader\Loaders\ConfigLoader;
use Illuminate\Support\ServiceProvider;
use Aedart\Config\Loader\Contracts\Loaders\ConfigLoader as ConfigLoaderInterface;

/**
 * <h1>Configuration Loader Service Provider</h1>
 *
 * Registers a default configuration loader
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Config\Loader\Providers
 */
class ConfigurationLoaderServiceProvider extends ServiceProvider{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register() {
        $this->app->bind(ConfigLoaderInterface::class, function($application){
            return new ConfigLoader();
        });
    }
}