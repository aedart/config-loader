<?php

use Aedart\Config\Loader\Factories\DefaultParserFactory;

/**
 * Class DefaultParserFactoryTest
 *
 * @group factories
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
     *
     * @expectedException \Aedart\Config\Loader\Exceptions\NoParserFoundException
     */
    public function failsWhenNoMatchingParserFound() {
        $factor = $this->getParserFactory();

        $factor->make($this->faker->word);
    }

    /**
     * @test
     */
    public function canMakeParserForPHPArray() {
        $this->assertCanMakeParserFor('php');
    }

    /**
     * @test
     */
    public function canMakeParserForJson() {
        $this->assertCanMakeParserFor('json');
    }

    /**
     * @test
     */
    public function canMakeParserForIni() {
        $this->assertCanMakeParserFor('ini');
    }

    /**
     * @test
     */
    public function canMakeParserForYaml() {
        $this->assertCanMakeParserFor('yml');
    }

    /**
     * @test
     */
    public function canMakeParserForYamlOldFileExtension() {
        $this->assertCanMakeParserFor('yaml');
    }
}