<?php
use Aedart\Config\Loader\Exceptions\ParseException;
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

    /**
     * Assert that the parser in question has a file type
     */
    public function assertHasFileType() {
        $parser = $this->makeParser();

        $type = $parser->getFileType();

        $this->assertInternalType('string', $type, 'File type must be a string');
        $this->assertNotEmpty($type, 'File type must not be empty!');
    }

    /**
     * Assert that the parser in question fails, when invalid
     * content is attempted to be parsed
     */
    public function assertFailsWhenOnInvalidContent() {
        $parser = $this->makeParser($this->getPathToInvalidFile());

        try {
            $parser->loadAndParse();
        } catch (ParseException $e){
            $this->assertTrue(true);
        } catch (Exception $e){
            $this->fail($e);
        }
    }

    /**
     * Assert that the parser in question is able to parse content
     */
    public function assertCanLoadAndParse() {
        $parser = $this->makeParser($this->getPathToValidFile());

        $output = $parser->loadAndParse();

        $this->assertInternalType('array', $output, 'Parser output must be an array');
        $this->assertNotEmpty($output, 'Configuration file might not contain any parse-able data');
    }

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