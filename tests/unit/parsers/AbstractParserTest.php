<?php

use Aedart\Config\Loader\Parsers\AbstractParser;
use Illuminate\Filesystem\Filesystem;
use \Mockery as m;

/**
 * Class AbstractParserTest
 *
 * @group parsers
 * @group abstract-parser
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 */
class AbstractParserTest extends ParserTestCase
{

    /**
     * <b>Override</b>
     *
     * Returns a mock of the abstract parser
     *
     * @param string $filePath [optional]
     *
     * @return m\MockInterface|AbstractParser
     */
    public function makeParser($filePath = null)
    {
        $parser = m::mock($this->getParserClassPath(), [$filePath])->makePartial();
        $parser->setFile(new Filesystem());

        return $parser;
    }

    /**
     * Get the class path for the configuration parser
     * in question
     *
     * @return string
     */
    public function getParserClassPath()
    {
        return AbstractParser::class;
    }

    /**
     * Returns a relative path to the given "valid" configuration
     * file that must be used
     *
     * @return string Relative path
     */
    public function getValidConfigurationFilePath()
    {
        return 'abstractParser/valid.php';
    }

    /**
     * Returns a relative path to the given "valid" configuration
     * file that must be used
     *
     * @return string Relative path
     */
    public function getInvalidValidConfigurationFilePath()
    {
        return 'abstractParser/invalid.php';
    }

    /****************************************************
     * Helpers
     ***************************************************/

    /****************************************************
     * Actual tests
     ***************************************************/

    /**
     * @test
     */
    public function canSetFilePathViaConstructor()
    {
        $parser = new DummyParser($this->getPathToValidFile());

        $this->assertSame($this->getPathToValidFile(), $parser->getFilePath());
    }

    /**
     * @test
     */
    public function canSetAndObtainFilePath()
    {
        $filePath = $this->getPathToValidFile();

        //$parser = $this->makeParser($filePath); // fails when mocked!?
        $parser = $this->makeParser();

        $parser->setFilePath($filePath);

        $this->assertTrue($parser->hasFilePath(), 'Should have a file path');
        $this->assertSame($filePath, $parser->getFilePath(), 'Incorrect file path returned');
    }

    /**
     * @test
     *
     * @expectedException \Aedart\Config\Loader\Exceptions\FileDoesNotExistException
     */
    public function failsWhenInvalidFilePathSpecified()
    {
        //$parser = $this->makeParser($this->faker->uuid); // fails when mocked!?
        $parser = $this->makeParser();
        $parser->setFilePath($this->faker->uuid);
    }

    /**
     * @test
     *
     * @expectedException \Aedart\Config\Loader\Exceptions\ParseException
     */
    public function failsToLoadAndInvokeParseWhenNoFilePathSpecified()
    {
        $parser = $this->makeParser();
        $parser->loadAndParse();
    }

    /**
     * @test
     */
    public function invokesParseWithFileContent()
    {
        $fs = new Filesystem();
        $filePath = $this->getPathToValidFile();
        $content = $fs->get($filePath);

        $parser = $this->makeParser();
        $parser->shouldReceive('parse')
            ->with($content)
            ->once()
            ->andReturn([]);

        $parser->setFilePath($filePath);

        $output = $parser->loadAndParse();

        $this->assertInternalType('array', $output);
    }
}

class DummyParser extends AbstractParser
{

    public static function getFileType() : string
    {
        return 'n/a';
    }

    public function parse(string $content) : array
    {
        return [];
    }
}