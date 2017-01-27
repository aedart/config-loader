<?php namespace Aedart\Config\Loader\Parsers;

use Aedart\Config\Loader\Exceptions\ParseException;
use Exception;
use Symfony\Component\Yaml\Yaml as SymfonyYamlParser;

/**
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
     * Returns the file extension, which this parser
     * is responsible for parsing
     *
     * @return string
     */
    public static function getFileType()
    {
        return 'yml';
    }

    /**
     * Parse the given content into an array
     *
     * @param string $content
     *
     * @return array
     *
     * @throws ParseException If given content could not be parsed
     */
    public function parse($content)
    {
        try {
            return SymfonyYamlParser::parse($content, true);
        } catch (Exception $e) {
            throw new ParseException(sprintf('Cannot parse "%s", content contains errors; %s', $this->getFilePath(),
                PHP_EOL . $e->getMessage()), $e->getCode(), $e);
        }
    }
}