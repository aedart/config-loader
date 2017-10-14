<?php

namespace Aedart\Config\Loader\Contracts;

use Aedart\Config\Loader\Contracts\Loaders\ConfigLoader;

/**
 * Config Loader Aware
 *
 * @see \Aedart\Config\Loader\Contracts\Loaders\ConfigLoader
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Config\Loader\Contracts
 */
interface ConfigLoaderAware
{
    /**
     * Set config loader
     *
     * @param ConfigLoader|null $loader Configuration Loader Instance
     *
     * @return self
     */
    public function setConfigLoader(?ConfigLoader $loader);

    /**
     * Get config loader
     *
     * If no config loader has been set, this method will
     * set and return a default config loader, if any such
     * value is available
     *
     * @see getDefaultConfigLoader()
     *
     * @return ConfigLoader|null config loader or null if none config loader has been set
     */
    public function getConfigLoader(): ?ConfigLoader;

    /**
     * Check if config loader has been set
     *
     * @return bool True if config loader has been set, false if not
     */
    public function hasConfigLoader(): bool;

    /**
     * Get a default config loader value, if any is available
     *
     * @return ConfigLoader|null A default config loader value or Null if no default value is available
     */
    public function getDefaultConfigLoader(): ?ConfigLoader;
}