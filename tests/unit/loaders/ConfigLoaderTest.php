<?php

use Aedart\Config\Loader\Contracts\Parsers\Parser;
use Aedart\Config\Loader\Loaders\ConfigLoader;
use Aedart\Testing\Laravel\TestCases\unit\UnitWithLaravelTestCase;
use Codeception\Configuration;
use \Mockery as m;

/**
 * Class ConfigLoaderTest
 *
 * @group loaders
 * @coversDefaultClass Aedart\Config\Loader\Loaders\ConfigLoader
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 */
class ConfigLoaderTest extends UnitWithLaravelTestCase{

    /*******************************************************
     * Helpers
     ******************************************************/

    /**
     * Make a new configuration loader instance
     *
     * @param string $directory [optional]
     * @param array $parsers [optional]
     *
     * @return ConfigLoader
     */
    public function makeConfigLoader($directory = null, array $parsers = []) {
        return new ConfigLoader($directory, $parsers);
    }

    /**
     * Returns the path to the configuration folder
     *
     * @return string
     *
     * @throws \Codeception\Exception\ConfigurationException
     */
    public function getDirectory() {
        return Configuration::dataDir() . 'loaders/';
    }

    /**
     * Returns a Parser mock
     *
     * @return m\MockInterface|Parser
     */
    public function getParserMock() {
        return m::mock(Parser::class);
    }

    /**
     * Get a blank mock instance
     *
     * @return m\MockInterface
     */
    public function getInvalidParserMock(){
        return m::mock();
    }

    /*******************************************************
     * Actual tests
     ******************************************************/

    /**
     * @test
     * @covers ::__construct
     * @covers ::getDirectory
     * @covers ::setDirectory
     * @covers ::hasDirectory
     */
    public function canSpecifyAndObtainDirectoryPath() {
        $directory = $this->getDirectory();

        $loader = $this->makeConfigLoader($directory);

        $this->assertTrue($loader->hasDirectory(), 'Should have a directory set');
        $this->assertSame($directory, $loader->getDirectory(), 'Incorrect directory set!');
    }

    /**
     * @test
     * @covers ::__construct
     * @covers ::setDirectory
     *
     * @expectedException \Aedart\Config\Loader\Exceptions\InvalidPathException
     */
    public function failsWhenInvalidDirectoryPathGiven() {
        $directory = $this->faker->uuid; // Just to provoke failure

        $this->makeConfigLoader($directory);
    }

    /**
     * @test
     * @covers ::__construct
     * @covers ::addParsers
     * @covers ::addParser
     * @covers ::hasParserFor
     * @covers ::getParsers
     */
    public function canAddParserViaClassPath() {
        $directory = $this->getDirectory();

        $fileExt = $this->faker->fileExtension;

        $parser = $this->getParserMock();
        $parser->shouldReceive('getFileType')
            ->andReturn($fileExt);

        $parsers = [
            get_class($parser)
        ];

        $loader = $this->makeConfigLoader($directory, $parsers);

        $this->assertTrue($loader->hasParserFor($fileExt));
    }

    /**
     * @test
     * @covers ::__construct
     * @covers ::addParsers
     * @covers ::addParser
     * @covers ::getParserFor
     * @covers ::hasParserFor
     * @covers ::getParsers
     */
    public function canAddParserViaInstance() {
        $directory = $this->getDirectory();

        $fileExt = $this->faker->fileExtension;

        $parser = $this->getParserMock();
        $parser->shouldReceive('getFileType')
            ->andReturn($fileExt);

        $parsers = [
            $parser
        ];

        $loader = $this->makeConfigLoader($directory, $parsers);

        $this->assertSame($parser, $loader->getParserFor($fileExt));
    }

    /**
     * @test
     * @covers ::__construct
     * @covers ::addParsers
     * @covers ::addParser
     *
     * @expectedException \Aedart\Config\Loader\Exceptions\InvalidParserException
     */
    public function failsWhenInvalidParserProvided() {
        $directory = $this->getDirectory();

        $fileExt = $this->faker->fileExtension;

        $parser = $this->getInvalidParserMock();

        $parsers = [
            $parser
        ];

        $this->makeConfigLoader($directory, $parsers);
    }

    /**
     * @test
     * @covers ::__construct
     * @covers ::addParsers
     * @covers ::addParser
     * @covers ::getParserFor
     * @covers ::hasParserFor
     * @covers ::getParsers
     * @covers ::removeParserFor
     */
    public function canRemoveParser() {
        $directory = $this->getDirectory();

        $fileExt = $this->faker->fileExtension;

        $parser = $this->getParserMock();
        $parser->shouldReceive('getFileType')
            ->andReturn($fileExt);

        $parsers = [
            $parser
        ];

        $loader = $this->makeConfigLoader($directory, $parsers);

        $loader->removeParserFor($fileExt);

        $this->assertFalse($loader->hasParserFor($fileExt));
    }

    /**
     * @test
     * @covers ::__construct
     * @covers ::addParsers
     * @covers ::addParser
     * @covers ::getParserFor
     * @covers ::hasParserFor
     * @covers ::getParsers
     * @covers ::removeParserFor
     *
     * @expectedException \Aedart\Config\Loader\Exceptions\NoParserFoundException
     */
    public function failsWhenAttemptingToRemoveNoneExistingParser() {
        $directory = $this->getDirectory();

        $fileExt = $this->faker->fileExtension;

        $parser = $this->getParserMock();
        $parser->shouldReceive('getFileType')
            ->andReturn($fileExt);

        $parsers = [
            $parser
        ];

        $loader = $this->makeConfigLoader($directory, $parsers);

        $loader->removeParserFor($this->faker->fileExtension);
    }

    /**
     * @test
     * @covers ::__construct
     * @covers ::getParsers
     *
     * @expectedException \Aedart\Config\Loader\Exceptions\NoParserFoundException
     */
    public function failsWhenInvalidParserIsAttemptedObtained() {
        $directory = $this->getDirectory();

        $fileExt = $this->faker->fileExtension;

        $parser = $this->getParserMock();
        $parser->shouldReceive('getFileType')
            ->andReturn($fileExt);

        $parsers = [
            $parser
        ];

        $loader = $this->makeConfigLoader($directory, $parsers);

        $loader->getParserFor($this->faker->fileExtension);
    }

    /**
     * @test
     * @covers ::__construct
     * @covers ::getParsers
     *
     * @covers ::setDefaultParsers
     */
    public function hasDefaultParsers() {
        $directory = $this->getDirectory();

        $fileExt = $this->faker->fileExtension;

        $parser = $this->getParserMock();
        $parser->shouldReceive('getFileType')
            ->andReturn($fileExt);

        $parsers = [
            $parser
        ];

        $loader = $this->makeConfigLoader($directory, $parsers);

        $this->assertTrue(count($loader->getParsers()) > 1, 'Configuration loader should have at least one default parser');
    }

    /**
     * @test
     * @covers ::load
     *
     * @expectedException \Aedart\Config\Loader\Exceptions\DirectoryNotSpecifiedException
     */
    public function failsLoadingAndParsingWhenNoDirectorySpecified() {
        $loader = $this->makeConfigLoader();

        $loader->load();
    }

    /**
     * @test
     * @covers ::load
     * @covers ::parse
     *
     * @expectedException \Aedart\Config\Loader\Exceptions\ParseException
     */
    public function failsWhenUnableToParse(){
        $directory = $this->getDirectory();

        $fileExt = 'php'; // This should override the default php array parser

        $parser = $this->getParserMock();
        $parser->shouldReceive('getFileType')
            ->andReturn($fileExt);

        $parser->shouldReceive('setFile')
            ->withAnyArgs();

        $parser->shouldReceive('setFilePath')
            ->withAnyArgs()
            ->andReturn($parser);

        $parser->shouldReceive('loadAndParse')
            ->withAnyArgs()
            ->andThrow(Exception::class);

        $parsers = [
            $parser
        ];

        $loader = $this->makeConfigLoader($directory, $parsers);

        $loader->load();
    }

    /**
     * We are only testing if the PHP Array parser works,
     * because parsers should be tested separately
     *
     * @test
     * @covers ::load
     * @covers ::parse
     */
    public function canParsePHPArrays() {
        $directory = $this->getDirectory();

        $loader = $this->makeConfigLoader($directory);

        $loader->load();

        $config = $loader->getConfig();

        $this->assertTrue($config->has('component.name'), 'Should have component name (value from configuration file)');
        $this->assertTrue($config->has('component.auto_init'), 'Should have component auto_init (value from configuration file)');
        $this->assertTrue($config->has('config.message'), 'Should have component message (value from configuration file)');
        $this->assertTrue($config->has('config.data'), 'Should have component data (value from configuration file)');
    }
}