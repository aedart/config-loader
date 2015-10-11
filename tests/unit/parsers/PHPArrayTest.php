<?php

use Aedart\Config\Loader\Parsers\PHPArray;

/**
 * Class PHPArrayTest
 *
 * @group parsers
 * @coversDefaultClass Aedart\Config\Loader\Parsers\PHPArray
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 */
class PHPArrayTest extends ParserTestCase{

    /**
     * Get the class path for the configuration parser
     * in question
     *
     * @return string
     */
    public function getParserClassPath() {
        return PHPArray::class;
    }

    /**
     * Returns a relative path to the given "valid" configuration
     * file that must be used
     *
     * @return string Relative path
     */
    public function getValidConfigurationFilePath() {
        return 'phpArray/valid.php';
    }

    /**
     * Returns a relative path to the given "valid" configuration
     * file that must be used
     *
     * @return string Relative path
     */
    public function getInvalidValidConfigurationFilePath() {
        return 'phpArray/invalid.php';
    }

    /******************************************************
     * Actual tests
     *****************************************************/

    /**
     * @test
     * @covers ::getFileType
     */
    public function hasAFileType() {
        $this->assertHasFileType();
    }

    /**
     * @test
     * @covers ::loadAndParse
     * @covers ::parse
     */
    public function failsWhenContentIsNotArray() {
        $this->assertFailsWhenOnInvalidContent();
    }

    /**
     * @test
     * @covers ::loadAndParse
     * @covers ::parse
     */
    public function canParsePHPArray() {
        $this->assertCanLoadAndParse();
    }

    /**
     * @test
     * @covers ::loadAndParse
     *
     * @expectedException \Aedart\Config\Loader\Exceptions\ParseException
     */
    public function failsLoadingAndParsingWhenNoFilePathGiven() {
        $parser = $this->makeParser();

        $parser->loadAndParse();
    }
}