<?php namespace Aedart\Config\Loader\Contracts;

use Aedart\Config\Loader\Contracts\Loaders\ConfigLoader;

/**
 * <h1>Config Loader Aware</h1>
 *
 * Component is aware of a configuration loader, which can be
 * specified and obtain.
 *
 * @see ConfigLoader
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Config\Loader\Traits
 */
interface ConfigLoaderAware
{

    /**
     * Set the given config loader
     *
     * @param ConfigLoader $loader Configuration Loader
     *
     * @return void
     */
    public function setConfigLoader(ConfigLoader $loader);

    /**
     * Get the given config loader
     *
     * If no config loader has been set, this method will
     * set and return a default config loader, if any such
     * value is available
     *
     * @see getDefaultConfigLoader()
     *
     * @return ConfigLoader|null config loader or null if none config loader has been set
     */
    public function getConfigLoader();

    /**
     * Get a default config loader value, if any is available
     *
     * @return ConfigLoader|null A default config loader value or Null if no default value is available
     */
    public function getDefaultConfigLoader();

    /**
     * Check if config loader has been set
     *
     * @return bool True if config loader has been set, false if not
     */
    public function hasConfigLoader();

    /**
     * Check if a default config loader is available or not
     *
     * @return bool True of a default config loader is available, false if not
     */
    public function hasDefaultConfigLoader();
}