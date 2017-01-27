<?php namespace Aedart\Config\Loader\Parsers;

use Aedart\Config\Loader\Contracts\Parsers\Parser;
use Aedart\Config\Loader\Exceptions\FileDoesNotExistException;
use Aedart\Config\Loader\Exceptions\ParseException;
use Aedart\Laravel\Helpers\Traits\Filesystem\FileTrait;

/**
 * <h1>Abstract Parser</h1>
 *
 * Abstraction for configuration parsers
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Config\Loader\Parsers
 */
abstract class AbstractParser implements Parser
{

    use FileTrait;

    /**
     * The file path that holds the configuration
     *
     * @var string
     */
    protected $filePath = null;

    /**
     * Create a new instance of this parser
     *
     * @param string $filePath [optional]
     */
    public function __construct($filePath = null)
    {
        if (!is_null($filePath)) {
            $this->setFilePath($filePath);
        }
    }

    public function setFilePath($filePath)
    {
        if (!is_file($filePath)) {
            throw new FileDoesNotExistException(sprintf('%s does not exist', $filePath));
        }

        $this->filePath = $filePath;

        return $this;
    }

    public function getFilePath()
    {
        return $this->filePath;
    }

    public function hasFilePath()
    {
        return !is_null($this->filePath);
    }

    public function loadAndParse()
    {
        if (!$this->hasFilePath()) {
            throw new ParseException('No file path has been specified');
        }

        $content = $this->getFile()->get($this->getFilePath());

        return $this->parse($content);
    }
}