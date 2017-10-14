<?php

use Aedart\Config\Loader\Parsers\Yaml;

/**
 * Class YamlTest
 *
 * @group parsers
 * @group yaml-parser
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 */
class YamlTest extends ParserTestCase
{

    /**
     * Get the class path for the configuration parser
     * in question
     *
     * @return string
     */
    public function getParserClassPath()
    {
        return Yaml::class;
    }

    /**
     * Returns a relative path to the given "valid" configuration
     * file that must be used
     *
     * @return string Relative path
     */
    public function getValidConfigurationFilePath()
    {
        return 'yaml/valid.yml';
    }

    /**
     * Returns a relative path to the given "valid" configuration
     * file that must be used
     *
     * @return string Relative path
     */
    public function getInvalidValidConfigurationFilePath()
    {
        return 'yaml/invalid.yml';
    }

    /******************************************************
     * Actual tests
     *****************************************************/

    /**
     * @test
     */
    public function hasAFileType()
    {
        $this->assertHasFileType();
    }

    /**
     * @test
     */
    public function failsWhenContentCannotBeParsed()
    {
        $this->assertFailsWhenOnInvalidContent();
    }

    /**
     * @test
     */
    public function canParseYaml()
    {
        $this->assertCanLoadAndParse();
    }
}