<?php

namespace Aedart\Config\Loader\Contracts\Loaders;

use Aedart\Config\Loader\Contracts\ParserFactoryAware;
use Aedart\Config\Loader\Contracts\Parsers\Parser;
use Aedart\Config\Loader\Exceptions\DirectoryNotSpecifiedException;
use Aedart\Config\Loader\Exceptions\InvalidPathException;
use Aedart\Config\Loader\Exceptions\ParseException;
use Aedart\Laravel\Helpers\Contracts\Config\ConfigAware;
use Aedart\Laravel\Helpers\Contracts\Filesystem\FileAware;
use Illuminate\Contracts\Config\Repository;

/**
 * <h1>Config Loader</h1>
 *
 * Responsible for loading and parsing various types of configuration files,
 * that are found in a given directory. The actual parsing is performed
 * by the loaders available configuration parsers.
 *
 * @see Parser
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Config\Loader\Loaders
 */
interface ConfigLoader extends ConfigAware,
    FileAware,
    ParserFactoryAware
{
    /**
     * Set the path to where the configuration
     * files are located
     *
     * @param string $path
     *
     * @return self
     *
     * @throws InvalidPathException If given path does not exist
     */
    public function setDirectory(string $path) : ConfigLoader;

    /**
     * Returns the path to where the configuration
     * files are located
     *
     * @return string|null
     */
    public function getDirectory() : ?string;

    /**
     * Check if a directory was set
     *
     * @return bool
     */
    public function hasDirectory(): bool;

    /**
     * Loads and parses the configuration files found inside
     * the specified directory
     *
     * @see getDirectory()
     * @see parse()
     * @see getConfig()
     *
     * @throws ParseException If unable to parse a given configuration file
     * @throws DirectoryNotSpecifiedException If no directory was specified
     */
    public function load(): void;

    /**
     * Parse the given configuration file, and return instance
     * of the repository, in which the configuration is contained
     *
     * @param string $filePath Path to configuration file
     *
     * @return Repository
     *
     * @throws ParseException If unable to parse given configuration file
     */
    public function parse(string $filePath) : Repository;
}