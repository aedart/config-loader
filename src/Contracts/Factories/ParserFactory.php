<?php namespace Aedart\Config\Loader\Contracts\Factories;

use Aedart\Config\Loader\Contracts\Parsers\Parser;
use Aedart\Config\Loader\Exceptions\NoParserFoundException;

/**
 * <h1>Parser Factory</h1>
 *
 * Responsible for creating parsers that match the given
 * file extension.
 *
 * @see Parser
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Config\Loader\Contracts\Factories
 */
interface ParserFactory {

    /**
     * Creates and returns a configuration parser, for the
     * given file extension
     *
     * @param string $fileExtension
     *
     * @return Parser
     *
     * @throws NoParserFoundException If no parser could be created for the given file extension
     */
    public function make($fileExtension);
}