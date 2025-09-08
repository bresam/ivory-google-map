# Place Autocomplete API

The Place Autocomplete service is a web service that returns place predictions in response to an HTTP request. The 
request specifies a textual search string and optional geographic bounds. The service can be used to provide 
autocomplete functionality for text-based geographic searches, by returning places such as businesses, addresses and 
points of interest as a user types.

The Place Autocomplete service can match on full words as well as substrings. Applications can therefore send queries 
as the user types, to provide on-the-fly place predictions. The returned predictions are designed to be presented to the 
user to aid them in selecting the desired place. You can send a [Place Details](/doc/service/place/detail/place_detail.md) 
request for more information about any of the places which are returned.

## Dependencies

The Place Autocomplete API requires an (PSR-18) http client and (PSR-17) request factory. It also requires the
[Ivory Serializer](https://github.com/egeloen/ivory-serializer) in order to deserialize the http response. To install
them, read this [documentation](/doc/installation.md).

## Build

First of all, if you want to process a place autocomplete, you will need to build a place autocomplete service. So 
let's go:

``` php
use Ivory\GoogleMap\Service\Direction\Place\Autocomplete\PlaceAutocompleteService;
use Symfony\Component\HttpClient\Psr18Client;
use Nyholm\Psr7\Factory\Psr17Factory;

$autocomplete = new PlaceAutocompleteService(new Psr18Client(), new Psr17Factory());
```

The direction constructor requires an `HttpClient` as first argument and a `RequestFactory` as second argument. Here,
I have chosen to use the [HttpClient](https://github.com/symfony/http-client) client as well as the
[Psr7](https://github.com/Nyholm/psr7) request factory.

The Place Autocomplete constructor also accepts a `SerializerInterface` as third argument. It is highly recommended to 
use it in order to configure a PSR-6 cache pool and so avoid parsing the built-in metadata every time.  

``` php
use Ivory\GoogleMap\Service\Place\Autocomplete\PlaceAutocompleteService;
use Ivory\GoogleMap\Service\Serializer\SerializerBuilder;
use Symfony\Component\HttpClient\Psr18Client;
use Nyholm\Psr7\Factory\Psr17Factory;

$autocomplete = new PlaceAutocompleteService(
    new Psr18Client(),
    new Psr17Factory(),
    SerializerBuilder::create($psr6Pool)
);
```

All services works the same way, so, if you want to learn more about it, you can read this common 
[documentation](/doc/service/service.md) about services.

## Request

Once you have built you place autocomplete service, you can process a request:

``` php
use Ivory\GoogleMap\Service\Place\Autocomplete\Request\PlaceAutocompleteRequest;

$response = $autocomplete->process(new PlaceAutocompleteRequest('Sydney'));
```

The place autocomplete service allows you to process a much more advance request. If you want to learn more about it, 
you can read its [documentation](/doc/service/place/autocomplete/place_autocomplete_request.md).

## Response

When you have requested the service, it gives you a response object. If you want to learn more about it, you can read 
its [documentation](/doc/service/place/autocomplete/place_autocomplete_response.md).

