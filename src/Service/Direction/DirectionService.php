<?php

/*
 * This file is part of the Ivory Google Map package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Ivory\GoogleMap\Service\Direction;

use Http\Client\HttpClient;
use Ivory\GoogleMap\Service\AbstractSerializableService;
use Ivory\GoogleMap\Service\Direction\Request\DirectionRequestInterface;
use Ivory\GoogleMap\Service\Direction\Response\DirectionResponse;
use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Client\ClientExceptionInterface;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class DirectionService extends AbstractSerializableService
{
    public function __construct(
        HttpClient $client,
        Psr17Factory $messageFactory,
        ?SerializerInterface $serializer = null
    ) {
        parent::__construct('https://maps.googleapis.com/maps/api/directions', $client, $messageFactory, $serializer);
    }

    /**
     * @throws ClientExceptionInterface
     */
    public function route(DirectionRequestInterface $request): DirectionResponse
    {
        $httpRequest = $this->createRequest($request);
        $httpResponse = $this->getClient()->sendRequest($httpRequest);

        $response = $this->deserialize(
            $httpResponse,
            DirectionResponse::class
        );

        $response->setRequest($request);

        return $response;
    }
}
