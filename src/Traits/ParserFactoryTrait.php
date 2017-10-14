<?php
declare(strict_types=1);

namespace Aedart\Config\Loader\Traits;

use Aedart\Config\Loader\Contracts\Factories\ParserFactory;
use Aedart\Config\Loader\Facades\ParserFactory as ParserFactoryFacade;

/**
 * Parser Factory Trait
 *
 * @see \Aedart\Config\Loader\Contracts\ParserFactoryAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Config\Loader\Traits
 */
trait ParserFactoryTrait
{
    /**
     * Parser Factory Instance
     *
     * @var ParserFactory|null
     */
    protected $parserFactory = null;

    /**
     * Set parser factory
     *
     * @param ParserFactory|null $factory Parser Factory Instance
     *
     * @return self
     */
    public function setParserFactory(?ParserFactory $factory)
    {
        $this->parserFactory = $factory;

        return $this;
    }

    /**
     * Get parser factory
     *
     * If no parser factory has been set, this method will
     * set and return a default parser factory, if any such
     * value is available
     *
     * @see getDefaultParserFactory()
     *
     * @return ParserFactory|null parser factory or null if none parser factory has been set
     */
    public function getParserFactory(): ?ParserFactory
    {
        if (!$this->hasParserFactory()) {
            $this->setParserFactory($this->getDefaultParserFactory());
        }
        return $this->parserFactory;
    }

    /**
     * Check if parser factory has been set
     *
     * @return bool True if parser factory has been set, false if not
     */
    public function hasParserFactory(): bool
    {
        return isset($this->parserFactory);
    }

    /**
     * Get a default parser factory value, if any is available
     *
     * @return ParserFactory|null A default parser factory value or Null if no default value is available
     */
    public function getDefaultParserFactory(): ?ParserFactory
    {
        return ParserFactoryFacade::getFacadeRoot();
    }
}