<?php namespace Aedart\Config\Loader\Parsers;

use Aedart\Config\Loader\Exceptions\ParseException;

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
class PHPArray extends AbstractParser {

    public static function getFileType() {
        return 'php';
    }

    public function loadAndParse() {
        if(!$this->hasFilePath()){
            throw new ParseException('No file path has been specified');
        }

        return $this->parse(require $this->getFilePath());
    }

    public function parse($content) {
        if(!is_array($content)){
            throw new ParseException(sprintf('Cannot parse %s, content is not a PHP array', $this->getFilePath()));
        }

        return $content;
    }
}