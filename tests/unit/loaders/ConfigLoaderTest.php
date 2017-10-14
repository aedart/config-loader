<?php

use Aedart\Config\Loader\Contracts\Factories\ParserFactory;
use Aedart\Config\Loader\Contracts\Parsers\Parser;
use Aedart\Config\Loader\Loaders\ConfigLoader;
use Aedart\Config\Loader\Providers\ConfigurationLoaderServiceProvider;
use Aedart\Testing\Laravel\TestCases\unit\UnitWithLaravelTestCase;
use Codeception\Configuration;
use \Mockery as m;

/**
 * Class ConfigLoaderTest
 *
 * @group loaders
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 */
class ConfigLoaderTest extends UnitWithLaravelTestCase{

    protected function getPackageProviders($app)
    {
        return [
            ConfigurationLoaderServiceProvider::class
        ];
    }

    /*******************************************************
     * Helpers
     ******************************************************/

    /**
     * Make a new configuration loader instance
     *
     * @param string $directory [optional]
     *
     * @return ConfigLoader
     */
    public function makeConfigLoader($directory = null) {
        return new ConfigLoader($directory);
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

    /**
     * Get a Parser Factory mock
     *
     * @return m\MockInterface|ParserFactory
     */
    public function getParserFactoryMock() {
        return m::mock(ParserFactory::class);
    }

    /*******************************************************
     * Actual tests
     ******************************************************/

    /**
     * @test
     */
    public function canSpecifyAndObtainDirectoryPath() {
        $directory = $this->getDirectory();

        $loader = $this->makeConfigLoader($directory);

        $this->assertTrue($loader->hasDirectory(), 'Should have a directory set');
        $this->assertSame($directory, $loader->getDirectory(), 'Incorrect directory set!');
    }

    /**
     * @test
     *
     * @expectedException \Aedart\Config\Loader\Exceptions\InvalidPathException
     */
    public function failsWhenInvalidDirectoryPathGiven() {
        $directory = $this->faker->uuid; // Just to provoke failure

        $this->makeConfigLoader($directory);
    }

    /**
     * @test
     *
     * @expectedException \Aedart\Config\Loader\Exceptions\DirectoryNotSpecifiedException
     */
    public function failsLoadingWhenNoDirectorySpecified() {
        $loader = $this->makeConfigLoader();
        $loader->load();
    }

    /**
     * @test
     *
     * @expectedException \Aedart\Config\Loader\Exceptions\ParseException
     */
    public function failsWhenUnableToParse() {
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

        $factory = $this->getParserFactoryMock();
        $factory->shouldReceive('make')
            ->with($fileExt)
            ->andReturn($parser);

        $loader = $this->makeConfigLoader($directory);
        $loader->setParserFactory($factory);

        $loader->load();
    }

    /**
     * We are only testing if the PHP Array parser works,
     * because parsers should be tested separately
     *
     * @test
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