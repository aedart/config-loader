<?php namespace Aedart\Config\Loader\Exceptions;

use InvalidArgumentException;

/**
 * @deprecated Use \Aedart\Contracts\Config\Parsers\Exceptions\FileDoesNotExistException, in aedart/athenaeum package
 *
 * File Does Not Exist Exception
 *
 * Throw this exception whenever a given file does not exist
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Config\Loader\Exceptions
 */
class FileDoesNotExistException extends InvalidArgumentException
{

}
