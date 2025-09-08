# Direction API

The Google Direction API is a service that calculates direction between locations using an HTTP request. You can
search for direction for several modes of transportation, include transit, driving, walking or cycling. Direction
may specify origins, destinations and waypoints either as text strings (e.g. "Chicago, IL" or "Darwin, NT, Australia")
or as latitude/longitude coordinates. The Direction API can return multi-part direction using a series of waypoints.

## Dependencies

The Direction API requires an (PSR-18) http client and (PSR-17) request factory. It also requires the 
[Ivory Serializer](https://github.com/egeloen/ivory-serializer) in order to deserialize the http response. To install 
them, read this [documentation](/doc/installation.md).

## Build

First of all, if you want to route a direction, you will need to build a direction service. So let's go:

``` php
use Ivory\GoogleMap\Service\Direction\DirectionService;
use Symfony\Component\HttpClient\Psr18Client;
use Nyholm\Psr7\Factory\Psr17Factory;

$direction = new DirectionService(new Psr18Client(), new Psr17Factory());
```

The direction constructor requires an `HttpClient` as first argument and a `RequestFactory` as second argument. Here, 
I have chosen to use the [HttpClient](https://github.com/symfony/http-client) client as well as the 
[Psr7](https://github.com/Nyholm/psr7) request factory.

The direction constructor also accepts a `SerializerInterface` as third argument. It is highly recommended to use it 
in order to configure a PSR-6 cache pool and so avoid parsing the built-in metadata every time.

``` php
use Ivory\GoogleMap\Service\Direction\DirectionService;
use Ivory\GoogleMap\Service\Serializer\SerializerBuilder;
use Symfony\Component\HttpClient\Psr18Client;
use Nyholm\Psr7\Factory\Psr17Factory;

$direction = new DirectionService(
    new Psr18Client(),
    new Psr17Factory(),
    SerializerBuilder::create($psr6Pool)
);
```

All services works the same way, so, if you want to learn more about it, you can read this common 
[documentation](/doc/service/service.md) about services.

## Request

Once you have built you direction service, you can request a direction:

``` php
use Ivory\GoogleMap\Service\Base\Location\AddressLocation;
use Ivory\GoogleMap\Service\Direction\Request\DirectionRequest;

$response = $direction->route(new DirectionRequest(
    new AddressLocation('New York'), 
    new AddressLocation('Washington')
));
```

The direction service allows you to route a much more advance request. If you want to learn more about it, you can 
read its [documentation](/doc/service/direction/direction_request.md).

## Response

When you have requested your direction, the service give you a response object. If you want to learn more about it, you 
can read its [documentation](/doc/service/direction/direction_response.md).
