<?php

namespace Aedart\Config\Loader\Facades;

use Illuminate\Support\Facades\Facade;
use Aedart\Config\Loader\Contracts\Loaders\ConfigLoader as ConfigLoaderInterface;

/**
 * <h1>Config Loader Facade</h1>
 *
 * @see \Aedart\Config\Loader\Loaders\ConfigLoader
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Config\Loader\Facades
 */
class ConfigLoader extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    protected static function getFacadeAccessor()
    {
        return ConfigLoaderInterface::class;
    }
}