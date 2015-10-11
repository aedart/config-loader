<?php namespace Aedart\Config\Loader\Facades;

use Illuminate\Support\Facades\Facade;
use Aedart\Config\Loader\Contracts\Factories\ParserFactory as ParserFactoryInterface;

/**
 * <h1>Parser Factory Facade</h1>
 *
 * @see \Aedart\Config\Loader\Factories\DefaultParserFactory
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Config\Loader\Facades
 */
class ParserFactory extends Facade{

    /**
     * Get the registered name of the component.
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    protected static function getFacadeAccessor()
    {
        return ParserFactoryInterface::class;
    }
}