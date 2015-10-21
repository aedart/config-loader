[![Latest Stable Version](https://poser.pugx.org/aedart/config-load/v/stable)](https://packagist.org/packages/aedart/config-load)
[![Total Downloads](https://poser.pugx.org/aedart/config-load/downloads)](https://packagist.org/packages/aedart/config-load)
[![Latest Unstable Version](https://poser.pugx.org/aedart/config-load/v/unstable)](https://packagist.org/packages/aedart/config-load)
[![License](https://poser.pugx.org/aedart/config-load/license)](https://packagist.org/packages/aedart/config-load)

# Config Loader

A utility for loading various types of configuration files and parse them to a Laravel Configuration Repository. This package contains a set of default
file-parsers, which can be applied. However, if you have a need for a different kind of parser, then you can "simply" create one, add it to the loader.

# Contents

* [When to use this](#when-to-use-this)
* [How to install](#how-to-install)
* [Quick start](#quick-start)
* [Contribution](#contribution)
* [Acknowledgement](#acknowledgement)
* [Versioning](#versioning)
* [License](#license)

## When to use this

* When your component depends on one or several of Laravel's native components
* When there is a strong need to interface such dependencies 
* When you need to be able to set a different instance of a given native Laravel component, e.g. your implemented version of a Configuration Repository


## How to install

```console

composer require aedart/config-load
```

This package uses [composer](https://getcomposer.org/). If you do not know what that is or how it works, I recommend that you read a little about, before attempting to use this package.

## Quick start

### Component-aware interface, and component-trait

Lets imagine that you have some kind of component, that needs to be aware of a configuration repository. You can ensure such, by implementing the `ConfigAware` interface.
Furthermore, a default implementation is available, via the `ConfigTrait` trait.

```php
<?php
use Aedart\Laravel\Helpers\Contracts\Config\ConfigAware;
use Aedart\Laravel\Helpers\Traits\Config\ConfigTrait;

class MyComponent implements ConfigAware {
    use ConfigTrait;
}
```

Now, your component is able to set and get an instance, of Laravel's `\Illuminate\Contracts\Config\Repository`. This means that, if you have a custom implementation of such a repository, then
you can specify it on the component;

```php
<?php

// Somewhere in you application...
$myComponent = new MyComponent();
$myComponent->setConfig($myCustomConfigRepository);

```

### Default fallback to Laravel's Facades

All traits have a default fallback method, which invokes Laravel's corresponding facades, ensuring that even if you do not specify an instance, a given component is returned;

```php
<?php

// When no custom configuration repository has been specified... 
$myComponent = new MyComponent();
$configRepository = $myComponent->getConfig(); // Uses fallback, invokes the `\Illuminate\Support\Facades\Config`, which is then resolved from the IoC Service Container 

```

### Usage inside a Laravel application

You do not need any special configuration or service provides. Just ensure that you have required this package as a dependency, and you are good to go.

### Outside a Laravel application

If you plan to use this package outside a Laravel application, then you might require additional dependencies.

**Example**

If you need to work with the filesystem components, then you must require Laravel's filesystem package;

```console

composer require illuminate/filesystem
```

#### IoC Service Container - no fallback

Fallback is not available, for any of the implemented traits, if this package is used outside a Laravel Application. It is up to you, to provide a fallback, if such is needed.
Should that be the case, then you can overwrite the `getDefaultXZY` methods, in your component.

```php
<?php
use Aedart\Laravel\Helpers\Contracts\Config\ConfigAware;
use Aedart\Laravel\Helpers\Traits\Config\ConfigTrait;
use Illuminate\Config\Repository;

class MyComponent implements ConfigAware {
    use ConfigTrait;
    
    public function getDefaultConfig() {
        return new Repository(); // Please note that this repository will NOT store values statically!
    }
}
```

As an alternative, you can also bind your dependencies and still use the facades. Read more about Laravel's [IoC Service Container](http://laravel.com/docs/5.1/container), in order to learn more about this.

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

* [Taylor Otwell](https://github.com/taylorotwell), for creating [Laravel](http://laravel.com) and especially the [Service Container](http://laravel.com/docs/5.1/container), that I'm using daily
* [Jeffrey Way](https://github.com/JeffreyWay), for creating [Laracasts](https://laracasts.com/) - a great place to learn new things... E.g. how to use the configuration repository

## Versioning

This package uses [Semantic Versioning 2.0.0](http://semver.org/)

## License

[BSD-3-Clause](http://spdx.org/licenses/BSD-3-Clause), Read the LICENSE file included in this package