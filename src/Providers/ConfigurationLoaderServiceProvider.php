<?php

namespace Aedart\Config\Loader\Providers;

use Aedart\Config\Loader\Factories\DefaultParserFactory;
use Aedart\Config\Loader\Loaders\ConfigLoader;
use Illuminate\Support\ServiceProvider;
use Aedart\Config\Loader\Contracts\Loaders\ConfigLoader as ConfigLoaderInterface;
use Aedart\Config\Loader\Contracts\Factories\ParserFactory as ParserFactoryInterface;

/**
 * @deprecated Use \Aedart\Config\Providers\ConfigLoaderServiceProvider, in aedart/athenaeum package
 *
 * <h1>Configuration Loader Service Provider</h1>
 *
 * Registers a default configuration loader
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Config\Loader\Providers
 */
class ConfigurationLoaderServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ParserFactoryInterface::class, function ($application) {
            return new DefaultParserFactory();
        });

        $this->app->bind(ConfigLoaderInterface::class, function ($application) {
            return new ConfigLoader();
        });
    }
}
