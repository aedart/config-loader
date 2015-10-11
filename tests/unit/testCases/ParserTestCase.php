<?php
use Aedart\Testing\Laravel\TestCases\unit\UnitTestCase;
use Codeception\Configuration;
use Illuminate\Filesystem\Filesystem;

/**
 * Class ParserTestCase
 *
 * Base test case for parsers
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 */
abstract class ParserTestCase extends UnitTestCase{

    /****************************************************
     * Helpers
     ***************************************************/

    /**
     * Get an instance of the configuration parser in
     * question
     *
     * @param string $filePath [optional]
     *
     * @return \Aedart\Config\Loader\Contracts\Parsers\Parser
     */
    public function makeParser($filePath = null) {
        $parser = $this->getParserClassPath();

        $resolvedParser = new $parser($filePath);
        $resolvedParser->setFile(new Filesystem());

        return $resolvedParser;
    }

    /**
     * Get a path to where parser's test configuration
     * files are located
     *
     * @return string
     */
    public function getDirectory() {
        return Configuration::dataDir() . 'parsers/';
    }

    /**
     * Get the full path to the valid configuration file
     *
     * @return string
     */
    public function getPathToValidFile() {
        return $this->getDirectory() . $this->getValidConfigurationFilePath();
    }

    /**
     * Get the full path to the invalid configuration file
     *
     * @return string
     */
    public function getPathToInvalidFile() {
        return $this->getDirectory() . $this->getInvalidValidConfigurationFilePath();
    }

    /****************************************************
     * Assertions
     ***************************************************/

    /****************************************************
     * Abstract methods
     ***************************************************/

    /**
     * Get the class path for the configuration parser
     * in question
     *
     * @return string
     */
    abstract public function getParserClassPath();

    /**
     * Returns a relative path to the given "valid" configuration
     * file that must be used
     *
     * @return string Relative path
     */
    abstract public function getValidConfigurationFilePath();

    /**
     * Returns a relative path to the given "valid" configuration
     * file that must be used
     *
     * @return string Relative path
     */
    abstract public function getInvalidValidConfigurationFilePath();
}