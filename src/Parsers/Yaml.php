<?php
declare(strict_types=1);

namespace Aedart\Config\Loader\Parsers;

use Aedart\Config\Loader\Exceptions\ParseException;
use Symfony\Component\Yaml\Yaml as SymfonyYamlParser;
use Throwable;

/**
 * @deprecated Use \Aedart\Config\Parsers\Files\Yaml, in aedart/athenaeum package
 *
 * <h1>YAML</h1>
 *
 * Parses YAML-configuration files, that consists of an array.
 *
 * @see https://en.wikipedia.org/wiki/YAML
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Config\Loader\Parsers
 */
class Yaml extends AbstractParser
{
    /**
     * @inheritdoc
     */
    public static function getFileType() : string
    {
        return 'yml';
    }

    /**
     * @inheritdoc
     */
    public function parse(string $content) : array
    {
        try {
            return SymfonyYamlParser::parse($content, SymfonyYamlParser::PARSE_EXCEPTION_ON_INVALID_TYPE);
        } catch (Throwable $e) {
            throw new ParseException(sprintf('Cannot parse "%s", content contains errors; %s', $this->getFilePath(),
                PHP_EOL . $e->getMessage()), $e->getCode(), $e);
        }
    }
}
