# Geocoder API

Geocoding is the process of converting addresses (like "1600 Amphitheatre Parkway, Mountain View, CA") into geographic
coordinates (like latitude 37.423021 and longitude -122.083739), which you can use to place markers or position the map.
Additionally, the service allows you to perform the converse operation (turning coordinates into addresses). This
process is known as "reverse geocoding".

## Dependencies

The Geocoder API requires an (PSR-18) http client and (PSR-17) request factory. It also requires the
[Ivory Serializer](https://github.com/egeloen/ivory-serializer) in order to deserialize the http response. To install
them, read this [documentation](/doc/installation.md).

## Build

First of all, if you want to geocode a position, you will need to build a geocoder provider. So let's go:

``` php
use Ivory\GoogleMap\Service\Geocoder\GeocoderService;
use Symfony\Component\HttpClient\Psr18Client;
use Nyholm\Psr7\Factory\Psr17Factory;

$geocoder = new GeocoderService(new Psr18Client(), new Psr17Factory());
```

The geocoder constructor requires an `HttpClient` as first argument and a `RequestFactory` as second argument. Here,
I have chosen to use the [HttpClient](https://github.com/symfony/http-client) client as well as the
[Psr7](https://github.com/Nyholm/psr7) request factory.

The geocoder constructor also accepts a `SerializerInterface` as third argument. It is highly recommended to use it in 
order to configure a PSR-6 cache pool and so avoid parsing the built-in metadata every time.  

``` php
use Ivory\GoogleMap\Service\Geocoder\GeocoderService;
use Ivory\GoogleMap\Service\Serializer\SerializerBuilder;
use Symfony\Component\HttpClient\Psr18Client;
use Nyholm\Psr7\Factory\Psr17Factory;

$geocoder = new GeocoderService(
    new Psr18Client(),
    new Psr17Factory(),
    SerializerBuilder::create($psr6Pool)
);
```

All services works the same way, so, if you want to learn more about it, you can read this common 
[documentation](/doc/service/service.md) about services.

## Request

Once you have built you geocoder provider, you can geocode a position or an address:

``` php
use Ivory\GoogleMap\Service\Geocoder\Request\GeocoderAddressRequest;

$request = new GeocoderAddressRequest('1600 Amphitheatre Parkway, Mountain View, CA');
$response = $geocoder->geocode($request);
```

The geocoder provider allows you to geocoder a much more advance request. If you want to learn more about it, you can 
read its [documentation](/doc/service/geocoder/geocoder_request.md).

## Response

When you have geocode your position, the provider give you a response object. If you want to learn more about it, you 
can read its [documentation](/doc/service/geocoder/geocoder_response.md).
