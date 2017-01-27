[![Latest Stable Version](https://poser.pugx.org/aedart/config-loader/v/stable)](https://packagist.org/packages/aedart/config-loader)
[![Total Downloads](https://poser.pugx.org/aedart/config-loader/downloads)](https://packagist.org/packages/aedart/config-loader)
[![Latest Unstable Version](https://poser.pugx.org/aedart/config-loader/v/unstable)](https://packagist.org/packages/aedart/config-loader)
[![License](https://poser.pugx.org/aedart/config-loader/license)](https://packagist.org/packages/aedart/config-loader)

# Config Loader

A utility for loading various types of configuration files and parse them to a Laravel Configuration Repository. This package contains a set of default
file-parsers, which can be applied. However, if you have a need for a different kind of parser, then you can "simply" create one, add it to the loader.

# Contents

* [When to use this](#when-to-use-this)
* [How to install](#how-to-install)
* [Quick start](#quick-start)
    * [Supported file types](#supported-file-types)
    * [Inside a Laravel project](#inside-a-laravel-project)
    * [Outside a Laravel project](#outside-a-laravel-project)
    * [Load and parse a single file](#load-and-parse-a-single-file)
    * [How to access the configuration](#how-to-access-the-configuration)
    * [Custom configuration file parser](#custom-configuration-file-parser)
* [Contribution](#contribution)
* [Acknowledgement](#acknowledgement)
* [Versioning](#versioning)
* [License](#license)

## When to use this

* When you need to load configuration from a file
* (When you need to load configuration from multiple files)


## How to install

```console

composer require aedart/config-loader
```

This package uses [composer](https://getcomposer.org/). If you do not know what that is or how it works, I recommend that you read a little about, before attempting to use this package.

## Quick start

### Supported file types

| File Extension  | Parser  |
|---|---|
| *.ini  | \Aedart\Config\Loader\Parsers\Ini  |
| *.json  | \Aedart\Config\Loader\Parsers\Json  |
| *.php (php array)  | \Aedart\Config\Loader\Parsers\PHPArray  |
| *.yml (also *.yaml) | \Aedart\Config\Loader\Parsers\Yaml  |

### Inside a Laravel project

#### Service Provider

The first thing you need to to, is to register the service provider;

```php
\Aedart\Config\Loader\Providers\ConfigurationLoaderServiceProvider::class
```

#### Load configuration

After you have specified the service provider, you can use the loader. In the following example, a directory path is provided and the files contained in that directory are loaded and parsed;

```php
use Aedart\Config\Loader\Loaders\ConfigLoader;

// Path to some directory that contains the configuration file(s)
$path = 'config/';

// Create a new loader instance
$loader = new ConfigLoader($path);

// Load and parse the configuration files
// NB: Is added directly to Laravel's configuration, can be accessed normally via the Config facade...
$loader->load();

// Obtain the configuration repository
$config = $loader->getConfig();

```

### Outside a Laravel project

When working outside a Laravel project, you need to create a few more instances, which the loader is dependent upon;

```php
use Aedart\Config\Loader\Loaders\ConfigLoader;
use Aedart\Config\Loader\Factories\DefaultParserFactory;
use Illuminate\Config\Repository;
use Illuminate\Filesystem\Filesystem;

// Path to some directory that contains the configuration file(s)
$path = 'config/';

// Create a new loader instance
$loader = new ConfigLoader($path);

// Specify the required dependencies
$loader->setConfig(new Repository());
$loader->setFile(new Filesystem());
$loader->setParserFactory(new DefaultParserFactory());

// Load and parse the configuration files
$loader->load();

// Obtain the configuration repository
$config = $loader->getConfig();

```

### Load and parse a single file

You can also load and parse a single file, instead of an entire directory;

```php

// Provided you have created an instance of the configuration loader,
// simply specify the full path to the configuration file
$config = $loader->parse('config/users.yml');

```

### How to access the configuration

If you are not familiar with Laravel's configuration repository, please review its [documentation](https://laravel.com/docs/5.4/configuration#accessing-configuration-values).

*Example PHP Array configuration file*

_(config/users.php)_

```php
return [
    'message' => 'Hallo World'
];

```

*Example of accessing the `message`*

```php

// ... (loading and parsing not shown) ...

// Fetch the message key
$message = $config->get('users.message');

echo $message; // Outputs 'Hallo World'

```

### Custom configuration file parser

If you need a custom parser, then you can create one by implementing the `\Aedart\Config\Loader\Contracts\Parsers\Parser` interface.

However, you also need to add your parser to a `parser factory`. Please review the `\Aedart\Config\Loader\Contracts\Factories\ParserFactory` interface, as well as the default
factory provided in this package; `\Aedart\Config\Loader\Factories\DefaultParserFactory`

## Contribution

Have you found a defect ( [bug or design flaw](https://en.wikipedia.org/wiki/Software_bug) ), or do you wish improvements? In the following sections, you might find some useful information
on how you can help this project. In any case, I thank you for taking the time to help me improve this project's deliverables and overall quality.

### Bug Report

If you are convinced that you have found a bug, then at the very least you should create a new issue. In that given issue, you should as a minimum describe the following;

* Where is the defect located
* A good, short and precise description of the defect (Why is it a defect)
* How to replicate the defect
* (_A possible solution for how to resolve the defect_)

When time permits it, I will review your issue and take action upon it.

### Fork, code and send pull-request

A good and well written bug report can help me a lot. Nevertheless, if you can or wish to resolve the defect by yourself, here is how you can do so;

* Fork this project
* Create a new local development branch for the given defect-fix
* Write your code / changes
* Create executable test-cases (prove that your changes are solid!)
* Commit and push your changes to your fork-repository
* Send a pull-request with your changes
* _Drink a [Beer](https://en.wikipedia.org/wiki/Beer) - you earned it_ :)

As soon as I receive the pull-request (_and have time for it_), I will review your changes and merge them into this project. If not, I will inform you why I choose not to.

## Acknowledgement

* [Taylor Otwell](https://github.com/taylorotwell), for creating [Laravel](http://laravel.com) and especially the [Service Container](https://laravel.com/docs/5.4/container), that I'm using daily
* [Jeffrey Way](https://github.com/JeffreyWay), for creating [Laracasts](https://laracasts.com/) - a great place to learn new things... E.g. how to use the configuration repository

## Versioning

This package follows [Semantic Versioning 2.0.0](http://semver.org/)

## License

[BSD-3-Clause](http://spdx.org/licenses/BSD-3-Clause), Read the LICENSE file included in this package
