<?php

/*
 * This file is part of the Ivory Google Map package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Ivory\GoogleMap\Service\Place;

use Ivory\GoogleMap\Service\AbstractSerializableService;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
abstract class AbstractPlaceSerializableService extends AbstractSerializableService
{
    /**
     * @param string|null $context
     */
    public function __construct(
        ClientInterface $client,
        RequestFactoryInterface $requestFactory,
        ?SerializerInterface $serializer = null,
        $context = null
    ) {
        if (null !== $context) {
            $context = '/'.$context;
        }

        parent::__construct(
            'https://maps.googleapis.com/maps/api/place'.$context,
            $client,
            $requestFactory,
            $serializer
        );
    }
}
