<?php namespace Aedart\Config\Loader\Loaders;

use Aedart\Config\Loader\Contracts\Loaders\ConfigLoader as ConfigLoaderInterface;
use Aedart\Config\Loader\Exceptions\DirectoryNotSpecifiedException;
use Aedart\Config\Loader\Exceptions\InvalidPathException;
use Aedart\Config\Loader\Exceptions\ParseException;
use Aedart\Config\Loader\Traits\ParserFactoryTrait;
use Aedart\Laravel\Helpers\Traits\Config\ConfigTrait;
use Aedart\Laravel\Helpers\Traits\Filesystem\FileTrait;
use Exception;

/**
 * <h1>Config Loader</h1>
 *
 * @see \Aedart\Config\Loader\Contracts\Loaders\ConfigLoader
 * @see \Aedart\Config\Loader\Contracts\Factories\ParserFactory
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Config\Loader\Loaders
 */
class ConfigLoader implements ConfigLoaderInterface {

    use ConfigTrait, FileTrait, ParserFactoryTrait;

    /**
     * Path to the directory that contains the
     * configuration files
     *
     * @var string
     */
    protected $directory = null;

    /**
     * Create a new instance of this configuration loader
     *
     * <br />
     *
     * NOTE: Configuration loader does contain some default
     * parsers.
     *
     * @see getParsers()
     *
     * @param string $directoryPath [optional]
     */
    public function __construct($directoryPath = null) {
        if(!is_null($directoryPath)){
            $this->setDirectory($directoryPath);
        }
    }

    /**
     * Set the path to where the configuration
     * files are located
     *
     * @param string $path
     *
     * @return $this
     *
     * @throws InvalidPathException If given path does not exist
     */
    public function setDirectory($path) {
        if(!is_dir($path)){
            throw new InvalidPathException(sprintf('%s does not appear to exist', $path));
        }

        $this->directory = $path;

        return $this;
    }

    /**
     * Returns the path to where the configuration
     * files are located
     *
     * @return string|null
     */
    public function getDirectory() {
        return $this->directory;
    }

    /**
     * Check if a directory was set
     *
     * @return bool
     */
    public function hasDirectory() {
        return !is_null($this->directory);
    }

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
    public function load() {
        if(!$this->hasDirectory()){
            throw new DirectoryNotSpecifiedException('Cannot load configuration files, because no directory was specified');
        }

        $files = $this->getFile()->files($this->getDirectory());

        foreach($files as $filePath){
            $this->parse($filePath);
        }
    }

    /**
     * Parse the given configuration file, and return instance
     * of the repository, in which the configuration is contained
     *
     * @param string $filePath Path to configuration file
     *
     * @return \Illuminate\Contracts\Config\Repository
     *
     * @throws ParseException If unable to parse given configuration file
     */
    public function parse($filePath) {
        try {
            // Get the file info for the given file
            $fileName = pathinfo($filePath, PATHINFO_FILENAME);
            $fileExtension = pathinfo($filePath, PATHINFO_EXTENSION);

            // Find a parser
            //$parser = $this->getParserFor($fileExtension);
            $parser = $this->getParserFactory()->make($fileExtension);

            // Set the filesystem instance that the parser must use
            $parser->setFile($this->getFile());

            // Parse the given configuration file
            $parsedContent = $parser->setFilePath($filePath)
                ->loadAndParse();

            // Set the configuration
            $config = $this->getConfig();
            $config->set(strtolower($fileName), $parsedContent);

            return $config;
        } catch (Exception $e){
            throw new ParseException(sprintf('Unable to parse %s; %s', $filePath, PHP_EOL . $e), $e->getCode(), $e);
        }
    }
}