<?php
declare(strict_types=1);

namespace Aedart\Config\Loader\Traits;

use Aedart\Config\Loader\Contracts\Loaders\ConfigLoader;
use Aedart\Config\Loader\Facades\ConfigLoader as ConfigLoaderFacade;

/**
 * Config Loader Trait
 *
 * @see \Aedart\Config\Loader\Contracts\ConfigLoaderAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Config\Loader\Traits
 */
trait ConfigLoaderTrait
{
    /**
     * Configuration Loader Instance
     *
     * @var ConfigLoader|null
     */
    protected $configLoader = null;

    /**
     * Set config loader
     *
     * @param ConfigLoader|null $loader Configuration Loader Instance
     *
     * @return self
     */
    public function setConfigLoader(?ConfigLoader $loader)
    {
        $this->configLoader = $loader;

        return $this;
    }

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
    public function getConfigLoader(): ?ConfigLoader
    {
        if (!$this->hasConfigLoader()) {
            $this->setConfigLoader($this->getDefaultConfigLoader());
        }
        return $this->configLoader;
    }

    /**
     * Check if config loader has been set
     *
     * @return bool True if config loader has been set, false if not
     */
    public function hasConfigLoader(): bool
    {
        return isset($this->configLoader);
    }

    /**
     * Get a default config loader value, if any is available
     *
     * @return ConfigLoader|null A default config loader value or Null if no default value is available
     */
    public function getDefaultConfigLoader(): ?ConfigLoader
    {
        return ConfigLoaderFacade::getFacadeRoot();
    }
}