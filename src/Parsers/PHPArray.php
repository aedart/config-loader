<?php
declare(strict_types=1);

namespace Aedart\Config\Loader\Parsers;

use Aedart\Config\Loader\Exceptions\ParseException;
use Throwable;

/**
 * <h1>PHP Array</h1>
 *
 * Parses php-configuration files, that consists of an array.
 *
 * Example; Laravel's default configuration files...
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Config\Loader\Parsers
 */
class PHPArray extends AbstractParser
{

    /**
     * @inheritdoc
     */
    public static function getFileType() : string
    {
        return 'php';
    }

    /**
     * @inheritdoc
     */
    public function loadAndParse() : array
    {
        if (!$this->hasFilePath()) {
            throw new ParseException('No file path has been specified');
        }

        return $this->parse($this->getFilePath());
    }

    /**
     * @inheritdoc
     */
    public function parse(string $content) : array
    {
        try{
            $fileContent = require $content;

            if (!is_array($fileContent)) {
                throw new ParseException(sprintf('Cannot parse %s, content is not a PHP array', $content));
            }

            return $fileContent;
        } catch (Throwable $e) {
            throw new ParseException(sprintf('Unable to load and parse %s', $content));
        }
    }
}