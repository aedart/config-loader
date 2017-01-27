<?php namespace Aedart\Config\Loader\Traits;

use Aedart\Config\Loader\Contracts\Loaders\ConfigLoader;
use Aedart\Config\Loader\Facades\ConfigLoader as ConfigLoaderFacade;

/**
 * <h1>Config Loader Trait</h1>
 *
 * @see \Aedart\Config\Loader\Contracts\ConfigLoaderAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Config\Loader\Traits
 */
trait ConfigLoaderTrait
{

    /**
     * Configuration Loader
     *
     * @var ConfigLoader|null
     */
    protected $configLoader = null;

    /**
     * Set the given config loader
     *
     * @param ConfigLoader $loader Configuration Loader
     *
     * @return void
     */
    public function setConfigLoader(ConfigLoader $loader)
    {
        $this->configLoader = $loader;
    }

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
    public function getConfigLoader()
    {
        if (!$this->hasConfigLoader() && $this->hasDefaultConfigLoader()) {
            $this->setConfigLoader($this->getDefaultConfigLoader());
        }
        return $this->configLoader;
    }

    /**
     * Get a default config loader value, if any is available
     *
     * @return ConfigLoader|null A default config loader value or Null if no default value is available
     */
    public function getDefaultConfigLoader()
    {
        return ConfigLoaderFacade::getFacadeRoot();
    }

    /**
     * Check if config loader has been set
     *
     * @return bool True if config loader has been set, false if not
     */
    public function hasConfigLoader()
    {
        return !is_null($this->configLoader);
    }

    /**
     * Check if a default config loader is available or not
     *
     * @return bool True of a default config loader is available, false if not
     */
    public function hasDefaultConfigLoader()
    {
        return !is_null($this->getDefaultConfigLoader());
    }
}