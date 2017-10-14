<?php
declare(strict_types=1);

namespace Aedart\Config\Loader\Loaders;

use Aedart\Config\Loader\Contracts\Loaders\ConfigLoader as ConfigLoaderInterface;
use Aedart\Config\Loader\Exceptions\DirectoryNotSpecifiedException;
use Aedart\Config\Loader\Exceptions\InvalidPathException;
use Aedart\Config\Loader\Exceptions\ParseException;
use Aedart\Config\Loader\Traits\ParserFactoryTrait;
use Aedart\Laravel\Helpers\Traits\Config\ConfigTrait;
use Aedart\Laravel\Helpers\Traits\Filesystem\FileTrait;
use Illuminate\Contracts\Config\Repository;
use Symfony\Component\Finder\SplFileInfo;
use Throwable;

/**
 * <h1>Config Loader</h1>
 *
 * @see \Aedart\Config\Loader\Contracts\Loaders\ConfigLoader
 * @see \Aedart\Config\Loader\Contracts\Factories\ParserFactory
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Config\Loader\Loaders
 */
class ConfigLoader implements ConfigLoaderInterface
{
    use ConfigTrait;
    use FileTrait;
    use ParserFactoryTrait;

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
    public function __construct(?string $directoryPath)
    {
        if(isset($directoryPath)){
            $this->setDirectory($directoryPath);
        }
    }

    /**
     * @inheritdoc
     */
    public function setDirectory(string $path) : ConfigLoaderInterface
    {
        if (!is_dir($path)) {
            throw new InvalidPathException(sprintf('%s does not appear to exist', $path));
        }

        $this->directory = $path;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getDirectory() : ?string
    {
        return $this->directory;
    }

    /**
     * @inheritdoc
     */
    public function hasDirectory() : bool
    {
        return isset($this->directory);
    }

    /**
     * @inheritdoc
     */
    public function load() : void
    {
        if (!$this->hasDirectory()) {
            throw new DirectoryNotSpecifiedException('Cannot load configuration files, because no directory was specified');
        }

        $files = $this->getFile()->files($this->getDirectory());

        foreach ($files as $filePath) {
            /** @var SplFileInfo $filePath */
            $this->parse($filePath->getRealPath());
        }
    }

    /**
     * @inheritdoc
     */
    public function parse(string $filePath) : Repository
    {
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
            $parsedContent = $parser->setFilePath($filePath)->loadAndParse();

            // Overload the configuration - we do not wish to
            // re-set an entire section of the configuration.
            $config = $this->getConfig();

            $section = strtolower($fileName);
            $existing = $config->get($section, []);
            $new = array_merge($existing, $parsedContent);

            $config->set($section, $new);

            return $config;
        } catch (Throwable $e) {
            throw new ParseException(sprintf('Unable to parse %s; %s', $filePath, PHP_EOL . $e), $e->getCode(), $e);
        }
    }
}