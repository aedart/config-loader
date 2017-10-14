<?php
declare(strict_types=1);

namespace Aedart\Config\Loader\Parsers;

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
     * @inheritdoc
     */
    public static function getFileType() : string
    {
        return 'json';
    }

    /**
     * @inheritdoc
     */
    public function parse(string $content) : array
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