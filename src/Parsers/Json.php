<?php namespace Aedart\Config\Loader\Parsers;

use Aedart\Config\Loader\Exceptions\ParseException;

/**
 * <h1>Json</h1>
 *
 * Parses json files
 *
 * Example; a composer file...
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Config\Loader\Parsers
 */
class Json extends AbstractParser
{

    /**
     * Returns the file extension, which this parser
     * is responsible for parsing
     *
     * @return string
     */
    public static function getFileType()
    {
        return 'json';
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
        $decoded = json_decode($content, true);

        if (json_last_error() != JSON_ERROR_NONE) {
            throw new ParseException(
                sprintf(
                    'Could not parse "%s", file contains errors; %s',
                    $this->getFilePath(),
                    PHP_EOL . json_last_error_msg()
                )
            );
        }

        return $decoded;
    }
}