# Installation

To install the Ivory Google Map library, you will need [Composer](http://getcomposer.org).  It's a PHP 5.3+ dependency 
manager which allows you to declare the dependent libraries your project needs and it will install & autoload them for 
you.

## Set up Composer

[Install Composer](https://getcomposer.org/)

## Download the library

Require the library in your `composer.json` file:

``` bash
composer require ivory/google-map
```

## Download additional libraries

### PSR-17 and PSR-18

If you want to use a service (geocoder, direction, ...), you will need an http client and request factory, this bundle is
built around the [PSR-17](https://www.php-fig.org/psr/psr-17/) and [PSR-18](https://www.php-fig.org/psr/psr-18/) specifications.
This means that any http client or request factory library which supports these specifications can be used within this bundle.

``` bash
composer require symfony/http-client
```

Here, I have chosen to use [HttpClient](https://github.com/symfony/http-client).

### Ivory Serializer

If you want to use a service (geocoder, direction, ...), you will need the 
[Ivory Serializer](https://github.com/egeloen/ivory-serializer) in order to deserialize the http response:

``` bash
composer require egeloen/serializer
```

## Autoload

So easy, you just have to require the generated autoload file and you are already ready to play:

``` php
<?php

require __DIR__.'/vendor/autoload.php';

use Ivory\GoogleMap;

// ...
```

The Ivory Google Map library follows the [PSR-4 Standard](http://www.php-fig.org/psr/psr-4/). 
If you prefer install it manually, it can be autoload by any convenient autoloader.
