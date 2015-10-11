<?php

use Aedart\Config\Loader\Factories\DefaultParserFactory;

/**
 * Class DefaultParserFactoryTest
 *
 * @group factories
 * @coversDefaultClass Aedart\Config\Loader\Factories\DefaultParserFactory
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 */
class DefaultParserFactoryTest extends ParserFactoryTestCase{

    /**
     * Returns the class path of the parser factory in question
     *
     * @return string
     */
    public function getFactoryClassPath() {
        return DefaultParserFactory::class;
    }

    /************************************************************
     * Actual tests
     ***********************************************************/

    /**
     * @test
     * @covers ::make
     *
     * @expectedException \Aedart\Config\Loader\Exceptions\NoParserFoundException
     */
    public function failsWhenNoMatchingParserFound() {
        $factor = $this->getParserFactory();

        $factor->make($this->faker->word);
    }

    /**
     * @test
     * @covers ::make
     */
    public function canMakeParserForPHPArray() {
        $this->assertCanMakeParserFor('php');
    }

    /**
     * @test
     * @covers ::make
     */
    public function canMakeParserForJson() {
        $this->assertCanMakeParserFor('json');
    }
}