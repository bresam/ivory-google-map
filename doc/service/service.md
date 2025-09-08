# Services

All services (direction, distance matrix, geocoder, ...) share common features.  

## Configure http client

If you want to update the service http client, you can use:

``` php
use Symfony\Component\HttpClient\Psr18Client;

$service->setClient(new Psr18Client());
```

Here, I have chosen to use the [HttpClient](https://github.com/symfony/http-client) client, which is probably already 
available within your project. But since this bundle is built around the [PSR-17](https://www.php-fig.org/psr/psr-17/) 
and [PSR-18](https://www.php-fig.org/psr/psr-18/) specifications, any library which supports these specifications can 
be used within this bundle.

## Configure http plugins

[Httplug](http://httplug.io/) supports a set of plugins we recommend to use in order to get better performance as well 
as a better experience with the library. The following are the most interesting ones:

 - Http Error Plugin: Convert 4xx & 5xx responses to exceptions.
 - Google Error Plugin: Convert Google invalid responses to exceptions.
 - Retry Plugin: Retry an error responses (exceptions).
 - Cache Plugin: Cache responses using a [PSR-6](http://www.php-fig.org/psr/psr-6/) compliant cache system.

To be able to use the plugins, you need to install [Httplug Bundle](https://packagist.org/packages/php-http/httplug-bundle) 
and configure them like:

``` yaml
httplug:
    classes:
        client: Symfony\Component\HttpClient\Psr18Client
        message_factory: Nyholm\Psr7\Factory\Psr17Factory
    clients:
        acme:
            factory: Symfony\Component\HttpClient\Psr18Client
```

To use these plugins, first install them:

``` bash
composer require php-http/client-common
composer require php-http/cache-plugin
composer require symfony/cache
```

Here, I have chosen to use the Symfony Cache PSR-6 component but you can choose your preferred one instead. 
Then, create a plugin client:

``` php
use Http\Client\Common\Plugin\CachePlugin;
use Http\Client\Common\Plugin\ErrorPlugin as HttpErrorPlugin;
use Http\Client\Common\Plugin\RetryPlugin;
use Ivory\GoogleMap\Service\Plugin\ErrorPlugin as GoogleErrorPlugin;
use Nyholm\Psr7\Factory\Psr17Factory;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\HttpClient\Psr18Client;

$service->setClient(new PluginClient(new Psr18Client(), [
    new RetryPlugin(),
    new HttpErrorPlugin(),
    new GoogleErrorPlugin(),
    new CachePlugin(
        new FilesystemAdapter(__DIR__.'/cache'),
        new Psr17Factory(),
        [
            'cache_lifetime'        => null,
            'default_ttl'           => null,
            'respect_cache_headers' => false,
        ]
    ),
]));
```

In this example, we use the `FilesystemAdapter` as well as an infinite caching strategy but you can configure it 
according to your needs. 

## Configure request factory

If you want to update the request factory, you can use:

``` php
use Nyholm\Psr7\Factory\Psr17Factory;

$service->setRequestFactory(new Psr17Factory());
```

Here, I have chosen to use the [Psr7](https://github.com/Nyholm/psr7) request factory. But since this bundle is built 
around the [PSR-17](https://www.php-fig.org/psr/psr-17/) and [PSR-18](https://www.php-fig.org/psr/psr-18/) 
specifications, any library which supports these specifications can be used within this bundle.

## Configure serializer

If you want to update the serializer, you can use:

``` php
use Ivory\Serializer\Serializer;

$service->setSerializer(new Serializer());
```

## Configure format

If you want to rely on XML instead of JSON, you wan use:

``` php
use Ivory\GoogleMap\Service\AbstractService;

$service->setFormat(AbstractService::FORMAT_XML);
```

## Configure API key

If you have an API key, you can use:

``` php
$service->setKey('api-key');
```

## Configure business account

If you want to use a service with a business account, you can read this [documentation](/doc/service/business_account.md).
