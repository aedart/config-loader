<?php namespace Aedart\Config\Loader\Contracts;

use Aedart\Config\Loader\Contracts\Factories\ParserFactory;

/**
 * <h1>Parser Factory Aware</h1>
 *
 * Component is aware of a Parser Factory, which is able to
 * make parsers, based on a given file extension.
 *
 * @see ParserFactory
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Config\Loader\Traits
 */
interface ParserFactoryAware {

    /**
     * Set the given parser factory
     *
     * @param ParserFactory $factory Instance of a Parser Factory
     *
     * @return void
     */
    public function setParserFactory(ParserFactory $factory);

    /**
     * Get the given parser factory
     *
     * If no parser factory has been set, this method will
     * set and return a default parser factory, if any such
     * value is available
     *
     * @see getDefaultParserFactory()
     *
     * @return ParserFactory|null parser factory or null if none parser factory has been set
     */
    public function getParserFactory();

    /**
     * Get a default parser factory value, if any is available
     *
     * @return ParserFactory|null A default parser factory value or Null if no default value is available
     */
    public function getDefaultParserFactory();

    /**
     * Check if parser factory has been set
     *
     * @return bool True if parser factory has been set, false if not
     */
    public function hasParserFactory();

    /**
     * Check if a default parser factory is available or not
     *
     * @return bool True of a default parser factory is available, false if not
     */
    public function hasDefaultParserFactory();
}