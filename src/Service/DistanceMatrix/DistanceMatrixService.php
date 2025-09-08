<?php

/*
 * This file is part of the Ivory Google Map package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Ivory\GoogleMap\Service\DistanceMatrix;

use Ivory\GoogleMap\Service\AbstractSerializableService;
use Ivory\GoogleMap\Service\DistanceMatrix\Request\DistanceMatrixRequestInterface;
use Ivory\GoogleMap\Service\DistanceMatrix\Response\DistanceMatrixResponse;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class DistanceMatrixService extends AbstractSerializableService
{
    public function __construct(
        ClientInterface $client,
        RequestFactoryInterface $requestFactory,
        ?SerializerInterface $serializer = null
    ) {
        parent::__construct(
            'https://maps.googleapis.com/maps/api/distancematrix',
            $client,
            $requestFactory,
            $serializer
        );
    }

    /**
     * @throws ClientExceptionInterface
     * @throws ExceptionInterface
     */
    public function process(DistanceMatrixRequestInterface $request): DistanceMatrixResponse
    {
        $httpRequest = $this->createRequest($request);
        $httpResponse = $this->getClient()->sendRequest($httpRequest);

        $response = $this->deserialize(
            $httpResponse,
            DistanceMatrixResponse::class
        );

        $response->setRequest($request);

        return $response;
    }
}
