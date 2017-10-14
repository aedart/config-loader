<?php

namespace Aedart\Config\Loader\Contracts;

use Aedart\Config\Loader\Contracts\Factories\ParserFactory;

/**
 * Parser Factory Aware
 *
 * @see \Aedart\Config\Loader\Contracts\Factories\ParserFactory
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Config\Loader\Contracts
 */
interface ParserFactoryAware
{
    /**
     * Set parser factory
     *
     * @param ParserFactory|null $factory Parser Factory Instance
     *
     * @return self
     */
    public function setParserFactory(?ParserFactory $factory);

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
    public function getParserFactory(): ?ParserFactory;

    /**
     * Check if parser factory has been set
     *
     * @return bool True if parser factory has been set, false if not
     */
    public function hasParserFactory(): bool;

    /**
     * Get a default parser factory value, if any is available
     *
     * @return ParserFactory|null A default parser factory value or Null if no default value is available
     */
    public function getDefaultParserFactory(): ?ParserFactory;
}