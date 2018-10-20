<?php
declare(strict_types=1);

namespace Aedart\Config\Loader\Parsers;

use Aedart\Config\Loader\Exceptions\ParseException;
use Throwable;

/**
 * @deprecated Use \Aedart\Config\Parsers\Files\Ini, in aedart/athenaeum package
 *
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
class Ini extends AbstractParser
{
    /**
     * @inheritdoc
     */
    public static function getFileType() : string
    {
        return 'ini';
    }

    /**
     * @inheritdoc
     */
    public function parse(string $content) : array
    {
        try {
            $result = parse_ini_string($content, true);

            if($result === false){
                throw new ParseException(sprintf('Cannot parse "%s", ini file contains errors', $this->getFilePath()));
            }

            return $result;

        } catch (Throwable $e) {
            throw new ParseException(sprintf(
                'Cannot parse "%s", content contains errors; %s', $this->getFilePath(),
                PHP_EOL . $e->getMessage()), $e->getCode(),
                $e
            );
        }
    }
}
