# TimeZone API

The Google Maps Time Zone API provides a simple interface to request the time zone for a location on the earth, as well 
as that location's time offset from UTC.

## Dependencies

The TimeZone API requires an (PSR-18) http client and (PSR-17) request factory. It also requires the
[Ivory Serializer](https://github.com/egeloen/ivory-serializer) in order to deserialize the http response. To install
them, read this [documentation](/doc/installation.md).

## Build

First of all, if you want to process a timezone, you will need to build a timezone service. So let's go:

``` php
use Ivory\GoogleMap\Service\TimeZone\TimeZoneService;
use Symfony\Component\HttpClient\Psr18Client;
use Nyholm\Psr7\Factory\Psr17Factory;

$timeZone = new TimeZoneService(new Psr18Client(), new Psr17Factory());
```

The direction constructor requires an `HttpClient` as first argument and a `RequestFactory` as second argument. Here,
I have chosen to use the [HttpClient](https://github.com/symfony/http-client) client as well as the
[Psr7](https://github.com/Nyholm/psr7) request factory.

The timezone constructor also accepts a `SerializerInterface` as third argument. It is highly recommended to use it in 
order to configure a PSR-6 cache pool and so avoid parsing the built-in metadata every time.  

``` php
use Ivory\GoogleMap\Service\Serializer\SerializerBuilder;
use Ivory\GoogleMap\Service\TimeZone\TimeZoneService;
use Symfony\Component\HttpClient\Psr18Client;
use Nyholm\Psr7\Factory\Psr17Factory;

$timeZone = new TimeZoneService(
    new Psr18Client(),
    new Psr17Factory(),
    SerializerBuilder::create($psr6Pool)
);
```

All services works the same way, so, if you want to learn more about them, you can read this common 
[documentation](/doc/service/service.md) about services.

## Request

Once you have built you timezone service, you can process a timezone:

``` php
use Ivory\GoogleMap\Base\Coordinate;
use Ivory\GoogleMap\Service\TimeZone\Request\TimeZoneRequest;

$response = $timeZone->process(new TimeZoneRequest(
    new Coordinate(39.6034810, -119.6822510),
    new \DateTime('@1331161200')
));
```

The timezone service allows you to route a much more advance request. If you want to learn more about it, you can 
read its [documentation](/doc/service/timezone/timezone_request.md).

## Response

When you have requested your timezone, the service give you a response object. If you want to learn more about it, you 
can read its [documentation](/doc/service/timezone/timezone_response.md).
