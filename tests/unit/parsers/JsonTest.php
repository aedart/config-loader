<?php

use Aedart\Config\Loader\Parsers\Json;

/**
 * Class JsonTest
 *
 * @group parsers
 * @coversDefaultClass Aedart\Config\Loader\Parsers\Json
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 */
class JsonTest extends ParserTestCase{

    /**
     * Get the class path for the configuration parser
     * in question
     *
     * @return string
     */
    public function getParserClassPath() {
        return Json::class;
    }

    /**
     * Returns a relative path to the given "valid" configuration
     * file that must be used
     *
     * @return string Relative path
     */
    public function getValidConfigurationFilePath() {
        return 'json/valid.json';
    }

    /**
     * Returns a relative path to the given "valid" configuration
     * file that must be used
     *
     * @return string Relative path
     */
    public function getInvalidValidConfigurationFilePath() {
        return 'json/invalid.json';
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
    public function failsWhenContentCannotBeDecoded() {
        $this->assertFailsWhenOnInvalidContent();
    }

    /**
     * @test
     * @covers ::loadAndParse
     * @covers ::parse
     */
    public function canParseJson() {
        $this->assertCanLoadAndParse();
    }
}