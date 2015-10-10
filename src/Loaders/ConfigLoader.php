<?php namespace Aedart\Config\Loader\Loaders;

use Aedart\Config\Loader\Contracts\Loaders\ConfigLoader as ConfigLoaderInterface;
use Aedart\Config\Loader\Contracts\Parsers\Parser;
use Aedart\Config\Loader\Exceptions\DirectoryNotSpecifiedException;
use Aedart\Config\Loader\Exceptions\InvalidParserException;
use Aedart\Config\Loader\Exceptions\InvalidPathException;
use Aedart\Config\Loader\Exceptions\NoParserFoundException;
use Aedart\Config\Loader\Exceptions\ParseException;
use Aedart\Config\Loader\Parsers\PHPArray;
use Aedart\Laravel\Helpers\Traits\Config\ConfigTrait;
use Aedart\Laravel\Helpers\Traits\Filesystem\FileTrait;
use Exception;

/**
 * <h1>Config Loader</h1>
 *
 * @see \Aedart\Config\Loader\Contracts\Loaders\ConfigLoader
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Config\Loader\Loaders
 */
class ConfigLoader implements ConfigLoaderInterface {

    use ConfigTrait, FileTrait;

    /**
     * Path to the directory that contains the
     * configuration files
     *
     * @var string
     */
    protected $directory = null;

    /**
     * List of file extensions their associated
     * configuration parser (created instance)
     *
     * @var array
     */
    protected $parsers = [];

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
     * @param array $parsers [optional]
     */
    public function __construct($directoryPath = null, array $parsers = []) {
        if(!is_null($directoryPath)){
            $this->setDirectory($directoryPath);
        }

        $this->setDefaultParsers();

        if(!empty($parsers)){
            $this->addParsers($parsers);
        }
    }

    /**
     * Sets the default available parsers
     *
     * @see addParsers()
     */
    protected function setDefaultParsers(){
        $this->addParsers([
            PHPArray::class
        ]);
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
            $parser = $this->getParserFor($fileExtension);

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

    /**
     * Add a list of configuration parsers to this loader
     *
     * @param string[]|Parser[] $parsers List of class paths or list of Parser instances
     */
    public function addParsers(array $parsers) {
        foreach($parsers as $parser){
            $this->addParser($parser);
        }
    }

    /**
     * Add a configuration parser to this loader's list of
     * available parsers
     *
     * @param string|Parser $parser Class path to parser or Parser instance
     *
     * @throws InvalidParserException If given parser is invalid
     */
    public function addParser($parser) {
        $resolvedParser = $parser;

        if(is_string($parser)){
            /** @var \Aedart\Config\Loader\Contracts\Parsers\Parser $resolvedParser */
            $resolvedParser = new $parser();
        }

        if(!($resolvedParser instanceof Parser)){
            throw new InvalidParserException(sprintf('%s must be instance of %s', var_export($parser, true), Parser::class));
        }

        $fileExtension = strtolower($resolvedParser::getFileType());

        $this->parsers[$fileExtension] = $parser;
    }

    /**
     * Returns a list of file extensions and their
     * associated configuration parsers
     *
     * @return array
     */
    public function getParsers() {
        return $this->parsers;
    }

    /**
     * Remove the configuration parser for the given file extension
     *
     * @param string $fileExtension
     *
     * @throws NoParserFoundException If matching parser found for the given file extension
     */
    public function removeParserFor($fileExtension) {
        if(!$this->hasParserFor($fileExtension)){
            throw new NoParserFoundException(sprintf('Cannot remove parser; No parser found for "%s" file extension', $fileExtension));
        }

        unset($this->parsers[strtolower($fileExtension)]);
    }

    /**
     * Check if a configuration parser exists for the
     * given file extension
     *
     * @param string $fileExtension
     *
     * @return bool
     */
    public function hasParserFor($fileExtension) {
        return array_key_exists(strtolower($fileExtension), $this->getParsers());
    }

    /**
     * Get a parser for the given file extension
     *
     * @param string $fileExtension
     *
     * @return Parser
     *
     * @throws NoParserFoundException If matching parser found for the given file extension
     */
    public function getParserFor($fileExtension) {
        if(!$this->hasParserFor($fileExtension)){
            throw new NoParserFoundException(sprintf('No parser found for "%s" file extension', $fileExtension));
        }

        return $this->getParsers()[strtolower($fileExtension)];
    }
}