<?php

use Aedart\Config\Loader\Providers\ConfigurationLoaderServiceProvider;
use Aedart\Config\Loader\Traits\ParserFactoryTrait;
use Aedart\Config\Loader\Contracts\Factories\ParserFactory;
use Aedart\Testing\Laravel\TestCases\unit\UnitWithLaravelTestCase;

/**
 * Class ParserFactoryTraitTest
 *
 * @group traits
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 */
class ParserFactoryTraitTest extends UnitWithLaravelTestCase
{

    protected function getPackageProviders($app)
    {
        return [
            ConfigurationLoaderServiceProvider::class
        ];
    }

    /************************************************
     * Helpers
     ***********************************************/

    /**
     * Get the trait in question
     *
     * @return PHPUnit_Framework_MockObject_MockObject|ParserFactoryTrait
     */
    public function getTraitMock()
    {
        return $this->getMockForTrait(ParserFactoryTrait::class);
    }

    /************************************************
     * Actual tests
     ***********************************************/

    /**
     * @test
     */
    public function canObtainDefaultParserFactory()
    {
        $trait = $this->getTraitMock();

        $factory = $trait->getParserFactory();

        $this->assertInstanceOf(ParserFactory::class, $factory);
    }

}