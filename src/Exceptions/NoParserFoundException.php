<?php namespace Aedart\Config\Loader\Exceptions;

use RuntimeException;

/**
 * @deprecated Use \Aedart\Contracts\Config\Parsers\Exceptions\NoFileParserFoundException, in aedart/athenaeum package
 *
 * No Parser Found Exception
 *
 * Throw this exception whenever a configuration parser is not
 * available or found, e.g. for a specific file extension
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Config\Loader\Exceptions
 */
class NoParserFoundException extends RuntimeException
{

}
