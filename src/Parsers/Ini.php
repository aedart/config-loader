<?php namespace Aedart\Config\Loader\Parsers;
use Aedart\Config\Loader\Exceptions\ParseException;
use Exception;

/**
 * <h1>Ini</h1>
 *
 * Parses ini-files
 *
 * Example; php's own configuration file
 *
 * <b>Note</b>: By default, this parser will process sections
 *
 * @see http://php.net/manual/en/function.parse-ini-file.php
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Config\Loader\Parsers
 */
class Ini extends AbstractParser{

    /**
     * Returns the file extension, which this parser
     * is responsible for parsing
     *
     * @return string
     */
    public static function getFileType() {
        return 'ini';
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
    public function parse($content) {
        try {
            return parse_ini_string($content, true);
        } catch(Exception $e){
            throw new ParseException(sprintf('Cannot parse "%s", content contains errors', $this->getFilePath()));
        }
    }
}