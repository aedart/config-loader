<?php
declare(strict_types=1);

namespace Aedart\Config\Loader\Parsers;

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
     * @param string|null $filePath [optional]
     */
    public function __construct(?string $filePath = null)
    {
        if (isset($filePath)) {
            $this->setFilePath($filePath);
        }
    }

    /**
     * @inheritdoc
     */
    public function setFilePath(string $filePath) : Parser
    {
        if (!is_file($filePath)) {
            throw new FileDoesNotExistException(sprintf('%s does not exist', $filePath));
        }

        $this->filePath = $filePath;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getFilePath() : ?string
    {
        return $this->filePath;
    }

    /**
     * @inheritdoc
     */
    public function hasFilePath() : bool
    {
        return !is_null($this->filePath);
    }

    /**
     * @inheritdoc
     */
    public function loadAndParse() : array
    {
        if (!$this->hasFilePath()) {
            throw new ParseException('No file path has been specified');
        }

        $content = $this->getFile()->get($this->getFilePath());

        return $this->parse($content);
    }
}