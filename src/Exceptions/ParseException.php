<?php namespace Aedart\Config\Loader\Exceptions;

use RuntimeException;

/**
 * @deprecated Use \Aedart\Contracts\Config\Parsers\Exceptions\FileParserException, in aedart/athenaeum package
 *
 * Parse Exception
 *
 * Throw this exception whenever a given configuration file's content
 * could not be parsed
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Config\Loader\Exceptions
 */
class ParseException extends RuntimeException
{

}
