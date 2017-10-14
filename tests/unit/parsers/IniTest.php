<?php

use Aedart\Config\Loader\Parsers\Ini;

/**
 * Class IniTest
 *
 * @group parsers
 * @group ini-parser
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 */
class IniTest extends ParserTestCase
{

    /**
     * Get the class path for the configuration parser
     * in question
     *
     * @return string
     */
    public function getParserClassPath()
    {
        return Ini::class;
    }

    /**
     * Returns a relative path to the given "valid" configuration
     * file that must be used
     *
     * @return string Relative path
     */
    public function getValidConfigurationFilePath()
    {
        return 'ini/valid.ini';
    }

    /**
     * Returns a relative path to the given "valid" configuration
     * file that must be used
     *
     * @return string Relative path
     */
    public function getInvalidValidConfigurationFilePath()
    {
        return 'ini/invalid.ini';
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
    public function canParseIni()
    {
        $this->assertCanLoadAndParse();
    }
}