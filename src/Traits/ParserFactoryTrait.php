<?php namespace Aedart\Config\Loader\Traits;

use Aedart\Config\Loader\Contracts\Factories\ParserFactory;
use Aedart\Config\Loader\Facades\ParserFactory as ParserFactoryFacade;

/**
 * <h1>Parser Factory Trait</h1>
 *
 * @see Aedart\Config\Loader\Contracts\ParserFactoryAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Config\Loader\Traits
 */
trait ParserFactoryTrait
{

    /**
     * Instance of a Parser Factory
     *
     * @var ParserFactory|null
     */
    protected $parserFactory = null;

    /**
     * Set the given parser factory
     *
     * @param ParserFactory $factory Instance of a Parser Factory
     *
     * @return void
     */
    public function setParserFactory(ParserFactory $factory)
    {
        $this->parserFactory = $factory;
    }

    /**
     * Get the given parser factory
     *
     * If no parser factory has been set, this method will
     * set and return a default parser factory, if any such
     * value is available
     *
     * @see getDefaultParserFactory()
     *
     * @return ParserFactory|null parser factory or null if none parser factory has been set
     */
    public function getParserFactory()
    {
        if (!$this->hasParserFactory() && $this->hasDefaultParserFactory()) {
            $this->setParserFactory($this->getDefaultParserFactory());
        }
        return $this->parserFactory;
    }

    /**
     * Get a default parser factory value, if any is available
     *
     * @return ParserFactory|null A default parser factory value or Null if no default value is available
     */
    public function getDefaultParserFactory()
    {
        static $factory;
        return isset($factory) ? $factory : $factory = ParserFactoryFacade::getFacadeRoot();
    }

    /**
     * Check if parser factory has been set
     *
     * @return bool True if parser factory has been set, false if not
     */
    public function hasParserFactory()
    {
        return isset($this->parserFactory);
    }

    /**
     * Check if a default parser factory is available or not
     *
     * @return bool True of a default parser factory is available, false if not
     */
    public function hasDefaultParserFactory()
    {
        $default = $this->getDefaultParserFactory();
        return isset($default);
    }
}