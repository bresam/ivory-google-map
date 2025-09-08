# Elevation API

The Google Maps Elevation API provides a simple interface to query locations on the earth for elevation data. 
Additionally, you may request sampled elevation data along paths, allowing you to calculate elevation changes along 
routes.

## Dependencies

The Elevation API requires an (PSR-18) http client and (PSR-17) request factory. It also requires the
[Ivory Serializer](https://github.com/egeloen/ivory-serializer) in order to deserialize the http response. To install
them, read this [documentation](/doc/installation.md).

## Build

First of all, if you want to process an elevation, you will need to build an elevation service. So let's go:

``` php
use Ivory\GoogleMap\Service\Elevation\ElevationService;
use Symfony\Component\HttpClient\Psr18Client;
use Nyholm\Psr7\Factory\Psr17Factory;

$elevation = new ElevationService(new Psr18Client(), new Psr17Factory());
```

The elevation constructor requires an `HttpClient` as first argument and a `RequestFactory` as second argument. Here,
I have chosen to use the [HttpClient](https://github.com/symfony/http-client) client as well as the
[Psr7](https://github.com/Nyholm/psr7) request factory.

The elevation constructor also accepts a `SerializerInterface` as third argument. It is highly recommended to use it in 
order to configure a PSR-6 cache pool and so avoid parsing the built-in metadata every time.  

``` php
use Ivory\GoogleMap\Service\Elevation\ElevationService;
use Ivory\GoogleMap\Service\Serializer\SerializerBuilder;
use Symfony\Component\HttpClient\Psr18Client;
use Nyholm\Psr7\Factory\Psr17Factory;

$elevation = new ElevationService(
    new Psr18Client(),
    new Psr17Factory(),
    SerializerBuilder::create($psr6Pool)
);
```

All services works the same way, so, if you want to learn more about it, you can read this common 
[documentation](/doc/service/service.md) about services.

## Request

Once you have built you elevation service, you can process an elevation:

``` php
use Ivory\GoogleMap\Base\Coordinate;
use Ivory\GoogleMap\Service\Base\Location\CoordinateLocation;
use Ivory\GoogleMap\Service\ELevation\PositionalElevationRequest;

$response = $elevation->process(new PositionalElevationRequest([
    new CoordinateLocation(new Coordinate(40.714728, -73.998672)),
    new CoordinateLocation(new Coordinate(-34.397, 150.644)),
]));
```

The elevation allows you to process a much more advanced request. If you want to lear more about it, you can read 
its [documentation](/doc/service/elevation/elevation_request.md).

## Response

When you have requested your elevation, the service give you a response object. If you want to learn more about 
it, you can read its [documentation](/doc/service/elevation/elevation_response.md).

