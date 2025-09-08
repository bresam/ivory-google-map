<?php

/*
 * This file is part of the Ivory Google Map package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Ivory\GoogleMap\Service;

use Ivory\GoogleMap\Service\Serializer\SerializerBuilder;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
abstract class AbstractSerializableService extends AbstractHttpService
{
    public const FORMAT_JSON = 'json';

    private SerializerInterface $serializer;
    private string $format = self::FORMAT_JSON;

    public function __construct(
        string $url,
        ClientInterface $client,
        RequestFactoryInterface $requestFactory,
        ?SerializerInterface $serializer = null
    ) {
        parent::__construct($url, $client, $requestFactory);

        $this->setSerializer($serializer ?: SerializerBuilder::create());
    }

    public function getSerializer(): SerializerInterface
    {
        return $this->serializer;
    }

    public function setSerializer(SerializerInterface $serializer): void
    {
        $this->serializer = $serializer;
    }

    /** @deprecated removed xml format and set json as static format */
    public function getFormat(): string
    {
        trigger_error('Method ' . __METHOD__ . ' is deprecated', E_USER_DEPRECATED);

        return $this->format;
    }

    /** @deprecated removed xml format and set json as static format */
    public function setFormat(string $format): void
    {
        trigger_error('Method ' . __METHOD__ . ' is deprecated', E_USER_DEPRECATED);
    }

    /** {@inheritdoc} */
    protected function createBaseUrl(RequestInterface $request): string
    {
        return parent::createBaseUrl($request).'/'.$this->format;
    }

    /**
     * @throws ExceptionInterface
     */
    protected function deserialize(ResponseInterface $response, string $type, array $context = []): mixed
    {
        return $this->serializer->deserialize((string) $response->getBody(), $type, $this->format, $context);
    }
}
