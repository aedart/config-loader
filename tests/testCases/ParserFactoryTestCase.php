<?php

use Aedart\Config\Loader\Contracts\Parsers\Parser;
use Aedart\Testing\TestCases\Unit\UnitTestCase;

/**
 * <h1>Parser Factory Test Case</h1>
 *
 * Base test case for parser factories
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 */
abstract class ParserFactoryTestCase extends UnitTestCase{

    /************************************************************
     * Helpers
     ************************************************************/

    /**
     * Get the Parser Factory in quesion
     *
     * @return \Aedart\Config\Loader\Contracts\Factories\ParserFactory
     */
    public function getParserFactory() {
        $factory = $this->getFactoryClassPath();
        return new $factory();
    }

    /************************************************************
     * Custom assertions
     ************************************************************/

    /**
     * Assert that the parser factory in question is able to
     * make and return a parser for the given file extension
     *
     * @param string $fileExtension
     */
    public function assertCanMakeParserFor($fileExtension) {
        $factor = $this->getParserFactory();

        $parser = $factor->make($fileExtension);

        $this->assertInstanceOf(Parser::class, $parser, sprintf('Could not make parser for "%s" file extension', $fileExtension));
    }

    /************************************************************
     * Abstract methods
     ************************************************************/

    /**
     * Returns the class path of the parser factory in question
     *
     * @return string
     */
    abstract public function getFactoryClassPath();

}