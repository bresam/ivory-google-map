# Place Search API

The Place Search API Web Service allows you to query for place information on a variety of categories, such as: 
establishments, prominent points of interest, geographic locations, and more. You can search for places either by 
proximity or a text string. A Place Search returns a list of places along with summary information about each place.

## Dependencies

The Place Search API requires an (PSR-18) http client and (PSR-17) request factory. It also requires the
[Ivory Serializer](https://github.com/egeloen/ivory-serializer) in order to deserialize the http response. To install
them, read this [documentation](/doc/installation.md).

## Build

First of all, if you want to process a place search, you will need to build a place search service. So let's go:

``` php
use Ivory\GoogleMap\Service\Place\Search\PlaceSearchService;
use Symfony\Component\HttpClient\Psr18Client;
use Nyholm\Psr7\Factory\Psr17Factory;

$search = new PlaceSearchService(new Psr18Client(), new Psr17Factory());
```

The direction constructor requires an `HttpClient` as first argument and a `RequestFactory` as second argument. Here,
I have chosen to use the [HttpClient](https://github.com/symfony/http-client) client as well as the
[Psr7](https://github.com/Nyholm/psr7) request factory.

The Place Detail constructor also accepts a `SerializerInterface` as third argument. It is highly recommended to 
use it in order to configure a PSR-6 cache pool and so avoid parsing the built-in metadata every time.  

``` php
use Ivory\GoogleMap\Service\Place\Search\PlaceSearchService;
use Ivory\GoogleMap\Service\Serializer\SerializerBuilder;
use Symfony\Component\HttpClient\Psr18Client;
use Nyholm\Psr7\Factory\Psr17Factory;

$search = new PlaceSearchService(
    new Psr18Client(),
    new Psr17Factory(),
    SerializerBuilder::create($psr6Pool)
);
```

All services works the same way, so, if you want to learn more about it, you can read this common 
[documentation](/doc/service/service.md) about services.

## Request

Once you have built you place search service, you can process a request:

``` php
use Ivory\GoogleMap\Service\Place\Search\Request\NearbyPlaceSearchRequest;
use Ivory\GoogleMap\Service\Place\Search\Request\PlaceSearchRankBy;

$iterator = $search->process(new NearbyPlaceSearchRequest(
    new Coordinate(-33.8670522, 151.1957362),
    PlaceSearchRankBy::PROMINENCE,
    1000
));
```

The place search service allows you to process a much more advance request. If you want to learn more about it, you 
can read its [documentation](/doc/service/place/search/place_search_request.md).

## Response

When you have requested the service, it gives you a response object. If you want to learn more about it, you can read 
its [documentation](/doc/service/place/search/place_search_response.md).

